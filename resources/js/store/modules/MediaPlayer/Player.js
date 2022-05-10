import dashjs from 'dashjs';
import store from "@js/store";

const Player = dashjs.MediaPlayer().create();

//
// Event handlers
//

//Loading
Player.on(dashjs.MediaPlayer.events["STREAM_INITIALIZING"], (e) => store.dispatch('MediaPlayer/handleEvent', e));
Player.on(dashjs.MediaPlayer.events["PLAYBACK_WAITING"], (e) => store.dispatch('MediaPlayer/handleEvent', e));
Player.on(dashjs.MediaPlayer.events["PLAYBACK_STALLED"], (e) => store.dispatch('MediaPlayer/handleEvent', e));

//Playing
Player.on(dashjs.MediaPlayer.events["PLAYBACK_PLAYING"], (e) => store.dispatch('MediaPlayer/handleEvent', e));

//Stopped
Player.on(dashjs.MediaPlayer.events["ERROR"], (e) => store.dispatch('MediaPlayer/handleEvent', e));
Player.on(dashjs.MediaPlayer.events["PLAYBACK_ERROR"], (e) => store.dispatch('MediaPlayer/handleEvent', e));
Player.on(dashjs.MediaPlayer.events["PLAYBACK_ENDED"], (e) => store.dispatch('MediaPlayer/handleEvent', e));
Player.on(dashjs.MediaPlayer.events["PLAYBACK_PAUSED"], (e) => store.dispatch('MediaPlayer/handleEvent', e));

export default Player;
