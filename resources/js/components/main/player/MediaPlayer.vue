<template>
    <div class="audio-player">
        <div class="media-info">
            <div v-if="nowPlaying" class="row row-sm align-items-center ps-2">
                <div class="col-auto">
                    <img class="rounded" height="48" v-bind:src="nowPlaying.media.coverImage" width="48">
                </div>
                <div class="col">
                    <span class="track-title">{{ nowPlaying.media.title }}</span>
                    <artist-list :artists="nowPlaying.media.artists" class="text-muted"></artist-list>
                </div>
            </div>
            <div v-else class="row row-sm align-items-center ps-2">
                <div class="col-auto ">
                    <b-icon-question
                        class="rounded border"
                        height="48"
                        width="48"
                    ></b-icon-question>
                </div>
                <div class="col">
                    <span class="track-title">Now playing: Unavailable</span>
                </div>
            </div>;
        </div>
        <div class="media-control-container">
            <div class="media-controls">
                <b-icon-hand-thumbs-up v-if="isAuthenticated" class="upvote"></b-icon-hand-thumbs-up>
                <play-button @click="onPlayPauseClick" :state="playerStatus"></play-button>
                <b-icon-hand-thumbs-down v-if="isAuthenticated" class="downvote"></b-icon-hand-thumbs-down>
            </div>
            <base-progressbar :pre-text="'01:45'" :post-text="'4:31'" :current-value="42"></base-progressbar>
        </div>
        <div class="extra-control">
            <div class="video-control" v-if="videoEnabled && playerStatus !== PlayerState.STOPPED" @click="handleVideoButtonClick">
                <b-icon-tv></b-icon-tv>
            </div>

            <div class="volume-control" class="btn-group dropup">
                <b-icon-volume-up
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                ></b-icon-volume-up>
                <div class="dropdown-menu bg-dark" v-on:click.stop>
                    <vue-slider
                        v-model="volume"
                        direction="btt"
                        v-bind:max="100"
                        v-bind:min="0"
                        @change="handleVolumeChange"
                    ></vue-slider>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import VueSlider from 'vue-slider-component';

import BaseProgressbar from "@components/BaseProgressbar";
import PlayButton from "@components/PlayButton";
import ArtistList from "@components/ArtistList";

import Request from '@js/models/Request';
import PlayerState from "@js/store/modules/MediaPlayer/PlayerState";

export default {
    components: {
        BaseProgressbar,
        PlayButton,
        VueSlider,
        ArtistList
    },
    data() {
        return {
            volume: 100,
            albumImage: require('@static/images/album_temp_bg.jpg'),
            url: "https://dash.akamaized.net/envivio/EnvivioDash3/manifest.mpd",
            showingVideo: false,
            PlayerState: PlayerState
        };
    },

    computed: {
        nowPlaying: () => Request.query()
                                     .where((r) => {
                                         return r.played_at !== null;
                                     })
                                     .orderBy('requested_at', 'asc')
                                     .with(["media.artists|album", "user"])
                                     .first(),
        ...mapGetters({
            isAuthenticated: 'isAuthenticated',
            playerStatus: 'MediaPlayer/getPlayerState',
            videoEnabled: 'MediaPlayer/hasVideo'
        })
    },

    mounted() {
        //Initialize
        this.player.initialize(document.querySelector("#mediaPlayerSource"), null, false);
    },

    methods: {
        onPlayPauseClick() {
            switch(this.playerStatus) {
                // Stop playing when clicked
                case PlayerState.PLAYING:
                    this.hideVideo();
                    this.$store.dispatch('MediaPlayer/stop');
                    break;
                // Start playing when clicked
                case PlayerState.STOPPED:
                    this.$store.dispatch('MediaPlayer/play', this.url);
                    break;
                // Probably loading, do nothing when clicked.
                default:
                    break;
            }
        },

        // Handle changes from the volume slider
        handleVolumeChange(volume) {
            if(volume > 0) {
                //Convert the int to a double
                volume = volume / 100;
            }

            this.player.setVolume(volume);
        },

        // Handle showing / hiding the video stream (if available)
        handleVideoButtonClick() {
            // Showing the video, so hide it
            if(this.showingVideo === true) {
                this.hideVideo();
            }
            // Not showing the video yet, show it
            else {
                this.showVideo();
            }
        },

        // Display the video stream
        showVideo() {
            document.querySelector("#mediaPlayerSource").classList.add("visible");
            document.querySelector("#video-control").classList.add("active");
            this.showingVideo = true;
            this.setHighVideoQuality();
        },

        // Hide the video stream
        hideVideo() {
            document.querySelector("#mediaPlayerSource").classList.remove("visible");
            document.querySelector("#video-control").classList.remove("active");
            this.showingVideo = false;
            this.setLowVideoQuality();
        },

        setLowVideoQuality() {
            this.player.updateSettings({'streaming': {'abr': {'autoSwitchBitrate': {'video': false}}}});
            this.player.setQualityFor("video", 0);
        },

        setHighVideoQuality() {
            this.player.updateSettings({'streaming': {'abr': {'autoSwitchBitrate': {'video': true}}}});
        }
    }
}
</script>

<style lang="scss">
.audio-player {
    width: 100%;
    height: 4.5rem;
    background: $body-bg;
    z-index: 9999;
    position: fixed;
    bottom: 0;
    display: flex;
    flex: 1 1 auto;

    & > div {
        display: flex;
        flex: 1;
        align-items: center;
    }

    .media-controls {
        margin-top: 0.5rem;
        margin-bottom: 0.1rem;
    }

    .media-info {
        justify-content: flex-start;

        .artists {
            font-size: 0.75rem;
        }
    }

    .media-control-container {
        justify-content: center;
        flex-direction: column;
        max-width: 500px;

        & > div {
            display: flex;
            align-items: center;
            flex-direction: row;
        }

        .upvote {
            cursor: pointer;
            margin-right: 1.25rem;
            width: 1.2rem;
            height: 1.2rem;
        }

        .downvote {
            cursor: pointer;
            margin-left: 1.25rem;
            width: 1.2rem;
            height: 1.2rem;
        }

        .media-progress {
            width: 100%;

            .progress {
                margin: 0 0.5rem;
                height: 0.35rem;
                width: 100%;
            }

            & > span {
                font-size: 0.75rem;
            }
        }
    }

    .extra-control {
        justify-content: flex-end;

        a {
            color: inherit;
        }

        & > * {
            margin-right: 1.5rem;
        }

        svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .video-control {
            cursor: pointer;

            &.active {
                color: $green;
            }
        }

        .volume-control {
            cursor: pointer;

            .dropdown-menu {
                min-width: 22px;
                max-width: 22px;
                height: 140px;

                .vue-slider {
                    height: 100% !important;
                }
            }
        }
    }
}
</style>
