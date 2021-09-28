<template>
    <div id="audio-player">
        <div class="media-info">
            <div v-if="currentRequest && currentRequest.media !== null" class="row row-sm align-items-center ps-2">
                <div class="col-auto">
                    <img class="rounded" height="48" v-bind:src="currentRequest.media.coverImage" width="48">
                </div>
                <div class="col">
                    <span class="track-title">{{ currentRequest.media.title }}</span>
                    <artist-list :artists="currentRequest.media.artists" class="text-muted"></artist-list>
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
            </div>
        </div>
        <div class="media-control">
            <div id="media-controls">
                <b-icon-hand-thumbs-up
                    v-if="isAuthenticated"
                    class="upvote"
                ></b-icon-hand-thumbs-up>
                <div id="playbutton">
                    <b-icon-play
                        v-if="playerStatus === PlayerState.STOPPED"
                        @click="play"
                    ></b-icon-play>

                    <div v-if="playerStatus === PlayerState.LOADING" class="spinner-border" role="status"></div>

                    <b-icon-stop
                        v-if="playerStatus === PlayerState.PLAYING"
                        @click="stop"
                    ></b-icon-stop>
                </div>
                <b-icon-hand-thumbs-down
                    v-if="isAuthenticated"
                    class="downvote"
                ></b-icon-hand-thumbs-down>
            </div>
            <div id="media-progress">
                <span>01:45</span>
                <div class="progress">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" class="progress-bar bg-blue" role="progressbar"
                         style="width: 42%"></div>
                </div>
                <span>4:31</span>
            </div>
        </div>
        <div class="extra-control">
            <b-icon-tv
                v-if="hasVideo && playerStatus !== PlayerState.STOPPED"
                id="video-control"
                @click="handleVideoButtonClick"
            >
            </b-icon-tv>

            <div id="volume-control" class="btn-group dropup">
                <b-icon-volume-up
                    data-toggle="dropdown"
                ></b-icon-volume-up>
                <div class="dropdown-menu" v-on:click.stop>
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

        <video id="mediaPlayerSource"></video>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import VueSlider from 'vue-slider-component';
import Request from '@js/models/Request';
import PlayerState from "@js/store/modules/MediaPlayer/PlayerState";
import ArtistList from "@js/components/global/media/ArtistList";

export default {
    components: {
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
        currentRequest: () => Request.query()
                                     .where((r) => {
                                         return r.played_at !== null;
                                     })
                                     .with(["media.artists|albums", "user"])
                                     .last(), ...mapGetters({
            isAuthenticated: 'isAuthenticated',
            playerStatus: 'MediaPlayer/getPlayerState',
            hasVideo: 'MediaPlayer/hasVideo'
        })
    },

    mounted() {
        //Initialize
        this.$player.initialize(document.querySelector("#mediaPlayerSource"), null, false);
    },

    methods: {
        play() {
            this.$store.dispatch('MediaPlayer/play', this.url);
        },

        stop() {
            this.hideVideo();
            this.$store.dispatch('MediaPlayer/stop');
        },

        // Handle changes from the volume slider
        handleVolumeChange(volume) {
            if(volume > 0) {
                //Convert the int to a double
                volume = volume / 100;
            }

            this.$player.setVolume(volume);
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
            this.$player.updateSettings({'streaming': {'abr': {'autoSwitchBitrate': {'video': false}}}});
            this.$player.setQualityFor("video", 0);
        },

        setHighVideoQuality() {
            this.$player.updateSettings({'streaming': {'abr': {'autoSwitchBitrate': {'video': true}}}});
        }
    }
}
</script>

<style lang="scss">
@import "~vue-slider-component/theme/default.css";

#mediaPlayerSource {
    display: none;

    &.visible {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: calc(100% - #{$player-height});
        background: #000;
    }
}

#audio-player {
    width: 100%;
    height: $player-height;
    background: $body-bg;
    z-index: 9999;
    position: fixed;
    bottom: 0;
    border-top: 1px solid darken($body-bg, 3%);
    display: flex;
    flex: 1 1 auto;

    & > div {
        display: flex;
        flex: 1;
        align-items: center;
    }

    #media-controls {
        margin-top: 0.5rem;
        margin-bottom: 0.1rem;
    }

    .media-info {
        justify-content: flex-start;

        .artists {
            font-size: 0.75rem;
        }
    }

    .media-control {
        justify-content: center;
        flex-direction: column;
        max-width: 500px;

        & > div {
            display: flex;
            align-items: center;
            flex-direction: row;
        }

        #playbutton {
            width: 2.5rem;
            height: 2.5rem;
            border: 1px solid $gray;
            border-radius: 50%;
            text-align: center;

            & > svg {
                width: 1.5rem;
                height: 1.5rem;
                margin: 0.45rem;
            }

            .spinner-border {
                margin-top: 7px;
            }
        }

        .upvote {
            margin-right: 1.25rem;
            width: 1.2rem;
            height: 1.2rem;
        }

        .downvote {
            margin-left: 1.25rem;
            width: 1.2rem;
            height: 1.2rem;
        }

        #media-progress {
            width: 100%;

            .progress {
                margin: 0 0.5rem;
                height: 0.35rem;
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

        #video-control {
            &.active {
                color: $green;
            }
        }

        #volume-control {
            .dropdown-menu {
                min-width: 22px;
                max-width: 22px;
                height: 140px;
            }
        }
    }
}
</style>
