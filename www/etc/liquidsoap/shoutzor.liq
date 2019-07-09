%include "config.liq"

# !! #################### !! #
# !! #################### !! #

# !! The entirety shoutzor.liq will be replaced by DarkIce (eventually) !! #

# !! #################### !! #
# !! #################### !! #

set("log.file.path",                shoutzorLogFilePath)
set("log.stdout",                   shoutzorLogStdout)
set("server.telnet",                shoutzorServerTelnet)
set("server.socket",                shoutzorServerSocket)
set("server.socket.path",           shoutzorServerSocketPath)
set("server.socket.permissions",    shoutzorServerSocketPermissions)

set("audio.converter.samplerate.libsamplerate.quality", "best")

# Add a skip function to a source
# when it does not have one
# by default
def add_skip_command(s) =
    # A command to skip
    def skip(_) =
        source.skip(s)
        "Done!"
    end
    # Register the command:
    server.register(namespace="#{source.id(s)}",
                     usage="skip",
                     description="Skip the current song.",
                     "skip",skip)
end

# Mixes two streams, with faded transitions between the state when only the
# normal stream is available and when the special stream gets added on top of
# it.
# @category Source / Track Processing
# @param ~delay   Delay before starting the special source.
# @param ~p       Portion of amplitude of the normal source in the mix.
# @param ~normal  The normal source, which could be called the carrier too.
# @param ~special The special source.
def smooth_add(~delay=0.5,~p=0.2,~normal,~special)
    d = delay
    fade.final = fade.final(duration=d*2.)
    fade.initial = fade.initial(duration=d*2.)
    q = 1. - p
    c = amplify
    fallback(track_sensitive=false, [special,normal], transitions = [
        fun(normal,special)->add(normalize=false, [c(p,normal), c(q,fade.final(type="sin",normal)), sequence([blank(duration=d),c(q,special)])]),
        fun(special,normal)->add(normalize=false, [c(p,normal), c(q,fade.initial(type="sin",normal))])
    ])
end

def smart_crossthing (~start_next=5.,~fade_in=3.,~fade_out=3.,
                     ~default=(fun (a,b) -> sequence([a, b])),
                     ~high=-15., ~medium=-32., ~margin=4.,
                     ~width=2.,~conservative=false,s)

  fade.out = fade.out(type="sin",duration=fade_out)
  fade.in  = fade.in(type="sin",duration=fade_in)
  add = fun (a,b) -> add(normalize=false,[b, a])
  log = log(label="smart_crossfade")

  def transition(a,b,ma,mb,sa,sb)
    list.iter(fun(x)-> log(level=4,"Before: #{x}"),ma)
    list.iter(fun(x)-> log(level=4,"After : #{x}"),mb)

    # If A and B are not too loud and close, fully cross-fade them.
    if a <= medium and b <= medium and abs(a - b) <= margin then
      log("Old <= medium, new <= medium and |old-new| <= margin.")
      log("Old and new source are not too loud and close.")
      log("Transition: crossed, fade-in, fade-out.")
      add(fade.out(sa),fade.in(sb))

    # If B is significantly louder than A, only fade-out A.
    # We don't want to fade almost silent things, ask for >medium.
    elsif b >= a + margin and a >= medium and b <= high then
      log("new >= old + margin, old >= medium and new <= high.")
      log("New source is significantly louder than old one.")
      log("Transition: crossed, fade-out.")
      add(fade.out(sa),sb)

    # Opposite as the previous one.
    elsif a >= b + margin and b >= medium and a <= high then
      log("old >= new + margin, new >= medium and old <= high")
      log("Old source is significantly louder than new one.")
      log("Transition: crossed, fade-in.")
      add(sa,fade.in(sb))

    # Do not fade if it's already very low.
    elsif b >= a + margin and a <= medium and b <= high then
      log("new >= old + margin, old <= medium and new <= high.")
      log("Do not fade if it's already very low.")
      log("Transition: crossed, no fade.")
      add(sa,sb)

    # Otherwise, A and B are just too loud to overlap nicely,
    # or the difference between them is too large and overlapping would
    # completely mask one of them.
    else
      log("No transition: using default.")
      default(sa, sb)
    end #/if
  end #/def

  smart_cross(width=width, duration=start_next, conservative=conservative, transition,s)
end #/def

def append_type(m) =
	[("type", "jingles")]
end

def metadatahandler(m)
	system("curl #{shoutzorUrl}/shoutzorapi?method=nexttrack &")
end

#Requester input
input = request.queue(id="shoutzorqueue")

# Attach a skip command to the source input:
add_skip_command(input)

input = on_track(metadatahandler, input)

#apply crossfade
input = smart_crossthing(start_next=5., fade_out=7., fade_in=5., conservative=true, input)

#give control over the channels
input = mksafe(input)

#stream output
output.icecast(
  encodingFormat,
  mount = wrapperInputListeningMount,
  id = "shoutzor",
  host = "localhost",
  port = wrapperInputListeningPort,
  password = wrapperInputListeningPassword,
  input)
