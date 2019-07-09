%include "config.liq"

set("log.file.path",                wrapperLogFilePath)
set("log.stdout",                   wrapperLogStdout)
set("server.telnet",                wrapperServerTelnet)
set("server.socket",                wrapperServerSocket)
set("server.socket.path",           wrapperServerSocketPath)
set("server.socket.permissions",    wrapperServerSocketPermissions)

def blank_handler()
  system("curl #{shoutzorUrl}/shoutzorapi?method=autofix &")
end

#In case nothing works anymore, say this
#TODO replace with Silent Wav
unfallibleSource = single("say: Shoutzor is experiencing technical difficulties, please stand by")

#give control over the channels
input = mix(id="nothingness", [unfallibleSource])

#the shoutzor.liq file will connect to this
#because of instability that stream might crash sometimes, this way
#it will automatically be able to fix itself without interrupting any stream connections
live = input.harbor(
    wrapperInputListeningMount,
    port = wrapperInputListeningPort,
    password = wrapperInputListeningPassword)

input = fallback(track_sensitive=false, [live, input])

#make sure the shoutzor script is running
input = on_blank(max_blank=15., blank_handler, input)

#stream output
output.icecast(
  encodingFormat,
  mount = wrapperOutputMount,
  id = "wrapper",
  host = wrapperOutputHost,
  port = wrapperOutputPort,
  password = wrapperOutputPassword,
  input)
