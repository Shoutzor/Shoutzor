import {
    MEDIA_FAILED,
    MEDIA_LOADING,
    MEDIA_PLAYING,
    MEDIA_STOPPED
} from "@models/mutation-types";
import {PlayerState} from "@models/PlayerState";
import dashjs from "dashjs";
import Player from "./Player";

const index = {
    namespaced: true,

    state: () => ({
        status: PlayerState.STOPPED,
        error: '',
        hasVideo: false
    }),

    mutations: {
        [MEDIA_STOPPED](state) {
            state.status = PlayerState.STOPPED;
            state.error = '';
        },
        [MEDIA_LOADING](state) {
            state.status = PlayerState.LOADING;
            state.error = '';
        },
        [MEDIA_PLAYING](state, hasVideo) {
            state.hasVideo = hasVideo;
            state.status = PlayerState.PLAYING;
            state.error = '';
        },
        [MEDIA_FAILED](state, message) {
            state.status = PlayerState.STOPPED;
            state.error = message;
        }
    },

    getters: {
        getPlayerState: state => state.status,
        getError: state => state.error,
        hasVideo: state => state.hasVideo
    },

    actions: {
        play({
                 commit,
                 dispatch
             }, url) {
            return new Promise((resolve, reject) => {
                Player.attachSource(url);
                Player.play();

                return resolve();
            });
        },

        stop({
                 commit,
                 dispatch
             }) {
            return new Promise((resolve, reject) => {
                Player.pause();
                Player.attachSource(null);
                commit(MEDIA_STOPPED);
                return resolve();
            });
        },

        handleEvent({
                        commit,
                        dispatch
                    }, e) {
            return new Promise((resolve, reject) => {
                if (e.type === dashjs.MediaPlayer.events["STREAM_INITIALIZING"] || e.type === dashjs.MediaPlayer.events["PLAYBACK_WAITING"] || e.type === dashjs.MediaPlayer.events["PLAYBACK_STALLED"]) {
                    commit(MEDIA_LOADING);
                    return resolve();
                }
                //Playing
                else {
                    if (e.type === dashjs.MediaPlayer.events["PLAYBACK_PLAYING"]) {
                        commit(MEDIA_PLAYING, (Player.getTracksFor("video").length > 0));
                        return resolve();
                    }
                    //Stopped
                    else {
                        if (e.type === dashjs.MediaPlayer.events["ERROR"] || e.type === dashjs.MediaPlayer.events["PLAYBACK_ERROR"] || e.type === dashjs.MediaPlayer.events["PLAYBACK_ENDED"] || e.type === dashjs.MediaPlayer.events["PLAYBACK_PAUSED"]) {
                            commit(MEDIA_STOPPED);
                            return resolve();
                        }
                    }
                }

                //Unknown event?
                console.error("Unknown event got passed tot the playerEventHandler, please report this (with a screenshot) to the shoutz0r github", e);
                reject("Unknown event got passed tot the playerEventHandler");
            });
        }
    }
}

export default index;
