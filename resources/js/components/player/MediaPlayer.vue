<template>
    <div id="audio-player">
        <div class="media-info" v-if="currentMedia">
            <div class="row row-sm align-items-center" v-if="currentMedia.media !== null">
                <div class="col-auto">
                    <img v-bind:src="albumImage" class="rounded" width="48" height="48">
                </div>
                <div class="col">
                    <span class="track-title">{{ currentMedia.media.title }}</span>
                    <artist-list class="text-muted" :artists="currentMedia.media.artists"></artist-list>
                </div>
            </div>
        </div>
        <div class="media-control">
            <div id="media-controls">
                <font-awesome-icon
                    class="upvote"
                    :icon="['fas', 'thumbs-up']"
                ></font-awesome-icon>
                <div id="playbutton">
                    <font-awesome-icon v-if="status === PlayerState.Stopped" @click="handlePlayButtonClick"
                        :icon="['fas', 'play']"
                    ></font-awesome-icon>
                    <div v-if="status === PlayerState.Loading" class="spinner-border" role="status"></div>
                    <font-awesome-icon v-if="status === PlayerState.Playing"  @click="handlePlayButtonClick"
                        :icon="['fas', 'stop']"
                    ></font-awesome-icon>
                </div>
                <font-awesome-icon
                    class="downvote"
                    :icon="['fas', 'thumbs-down']"
                ></font-awesome-icon>
            </div>
            <div id="media-progress">
                <span>01:45</span>
                <div class="progress">
                    <div class="progress-bar bg-blue" style="width: 42%" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span>4:31</span>
            </div>
        </div>
        <div class="extra-control">
            <font-awesome-icon
                v-if="hasVideo === true && status !== PlayerState.Stopped"
                :icon="['fas', 'tv']"
                id="video-control"
                @click="handleVideoButtonClick"
            ></font-awesome-icon>

            <div id="volume-control" class="btn-group dropup">
                <font-awesome-icon
                    data-toggle="dropdown"
                    :icon="['fas', 'volume-up']"
                ></font-awesome-icon>
                <div class="dropdown-menu" v-on:click.stop>
                    <vue-slider
                        v-model="volume"
                        direction="btt"
                        v-bind:min="0"
                        v-bind:max="100"
                        @change="handleVolumeChange"
                    ></vue-slider>
                </div>
            </div>
        </div>

        <video id="mediaPlayerSource"></video>
    </div>
</template>

<script>
    import History from '@js/models/History';
    import VueSlider from 'vue-slider-component'
    import dashjs from 'dashjs';

    const PlayerState = Object.freeze({
        Stopped: 0,
        Loading: 1,
        Playing: 2
    });

    export default {
        components: {
            VueSlider
        },
        data() {
            return {
                volume: 100,
                albumImage: require('@static/images/album_temp_bg.jpg'),
                player: null,
                url: "https://dash.akamaized.net/envivio/EnvivioDash3/manifest.mpd",
                status: PlayerState.Stopped,
                showingVideo: false,
                hasVideo: false,
                PlayerState
            };
        },

        computed: {
            currentMedia: () => History.query().with(["media.artists|albums", "user"]).last()
        },

        created() {
            History.api().fetchNowPlaying();
        },

        mounted() {
            //Initialize the player object on component load
            this.initializePlayer();

            //
            // Event handlers
            //

            //Pre-buffering
            this.player.on(dashjs.MediaPlayer.events["STREAM_INITIALIZED"], this.preBufferSetup);

            //Loading
            this.player.on(dashjs.MediaPlayer.events["STREAM_INITIALIZING"], this.handlePlayerEvent);
            this.player.on(dashjs.MediaPlayer.events["PLAYBACK_WAITING"], this.handlePlayerEvent);
            this.player.on(dashjs.MediaPlayer.events["PLAYBACK_STALLED"], this.handlePlayerEvent);

            //Playing
            this.player.on(dashjs.MediaPlayer.events["PLAYBACK_PLAYING"], this.handlePlayerEvent);

            //Stopped
            this.player.on(dashjs.MediaPlayer.events["ERROR"], this.handlePlayerEvent);
            this.player.on(dashjs.MediaPlayer.events["PLAYBACK_ERROR"], this.handlePlayerEvent);
            this.player.on(dashjs.MediaPlayer.events["PLAYBACK_ENDED"], this.handlePlayerEvent);
            this.player.on(dashjs.MediaPlayer.events["PLAYBACK_PAUSED"], (e) => {
                this.stop();
                this.handlePlayerEvent(e);
            });
        },

        methods: {
            initializePlayer() {
                this.player = dashjs.MediaPlayer().create();
                this.player.initialize(document.querySelector("#mediaPlayerSource"), null, false);
            },

            preBufferSetup() {
                if(this.player.getTracksFor("video").length > 0) {
                    this.hasVideo = true;
                    this.setLowVideoQuality();
                } else {
                    this.hasVideo = false;
                }
            },

            handlePlayerEvent(e) {
                //Loading
                if(
                    e.type === dashjs.MediaPlayer.events["STREAM_INITIALIZING"] ||
                    e.type === dashjs.MediaPlayer.events["PLAYBACK_WAITING"] ||
                    e.type === dashjs.MediaPlayer.events["PLAYBACK_STALLED"]
                ) {
                    this.status = PlayerState.Loading;
                }
                //Playing
                else if(e.type === dashjs.MediaPlayer.events["PLAYBACK_PLAYING"]) {
                    this.status = PlayerState.Playing;
                }
                //Stopped
                else if(
                    e.type === dashjs.MediaPlayer.events["ERROR"] ||
                    e.type === dashjs.MediaPlayer.events["PLAYBACK_ERROR"] ||
                    e.type === dashjs.MediaPlayer.events["PLAYBACK_ENDED"] ||
                    e.type === dashjs.MediaPlayer.events["PLAYBACK_PAUSED"]
                ) {
                    this.status = PlayerState.Stopped;
                }
                //Unknown event?
                else {
                    console.error("Unknown event got passed tot the playerEventHandler, please report this (with a screenshot) to the shoutz0r github", e);
                }
            },

            // Handle the play/stop button click event
            handlePlayButtonClick() {
                if(this.status === PlayerState.Stopped) {
                    this.play();
                } else {
                    this.stop();
                }
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

            // Handle changes from the volume slider
            handleVolumeChange(volume) {
                if(volume > 0) {
                    //Convert the int to a double
                    volume = volume / 100;
                }

                this.player.setVolume(volume);
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
                this.player.updateSettings({ 'streaming': { 'abr': { 'autoSwitchBitrate': { 'video': false } } } });
                this.player.setQualityFor("video", 0);
            },

            setHighVideoQuality() {
                this.player.updateSettings({ 'streaming': { 'abr': { 'autoSwitchBitrate': { 'video': true } } } });
            },

            // Load & start playback
            play() {
                this.player.attachSource(this.url);
                this.player.play();
                this.status = PlayerState.Loading;
            },

            // Stop playback & unload
            stop() {
                this.hideVideo();
                this.player.pause();
                this.player.attachSource(null);
                this.status = PlayerState.Stopped;
            }
        }
    }
</script>

<style lang="scss">
    @import '~vue-slider-component/theme/default.css';

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
        border-top: 1px solid darken($body-bg, 10%);
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
            padding-left: 1rem;
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
                    width: 1rem;
                    height: 1rem;
                    margin: 0.75rem;
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
