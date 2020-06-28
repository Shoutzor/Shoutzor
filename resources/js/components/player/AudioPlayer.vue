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
                    <font-awesome-icon
                        :icon="['fas', 'play']"
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
        <div class="volume-control">
            <router-link
                :to="{name: 'tv'}"
            >
                <font-awesome-icon
                    :icon="['fas', 'tv']"
                ></font-awesome-icon>
            </router-link>

            <div class="btn-group dropup">
                <font-awesome-icon
                    data-toggle="dropdown"
                    :icon="['fas', 'volume-up']"
                ></font-awesome-icon>
                <div class="dropdown-menu show" style="display:block;height:200px;-ms-flex: none;box-sizing: default;
    -webkit-box-flex: 0;
    flex: none;">
                    <veeno
                        id="volume-slider"
                        vertical
                        connect
                        rtl
                        tooltips
                        :step="1"
                        :handles="100"
                        :range = "{
                            'min': 0,
                            'max': 100
                    }"></veeno>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import veeno from 'veeno';
    import History from '@js/models/History';

    export default {
        components: {
            veeno
        },
        data() {
            return {
                albumImage: require('@static/images/album_temp_bg.jpg')
            };
        },

        computed: {
            currentMedia: () => History.query().with(["media.artists|albums", "user"]).last()
        },

        created() {
            History.api().fetchNowPlaying();
        }
    }
</script>

<style lang="scss">
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
            margin-top: 0.2rem;
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
                width: 2.75rem;
                height: 2.75rem;
                border: 1px solid $gray;
                border-radius: 50%;
                text-align: center;

                & > svg {
                    width: 1.25rem;
                    height: 1.25rem;
                    margin: 0.75rem;
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

        .volume-control {
            justify-content: flex-end;

            & > * {
                margin-right: 1.5rem;
            }

            svg {
                width: 1.25rem;
                height: 1.25rem;
            }

            .dropdown-menu {
                min-width: 22px;
                max-width: 22px;

                &.show {
                    display: block;
                    justify-content: center;
                }

                #volume-slider {
                    .noUi-base {
                        width: 0.75rem;
                        margin: 0 auto;
                    }

                    .noUi-origin {
                        height: 100%;

                        .noUi-handle {
                            border: 0;
                            margin-left: -2px;

                            .noUi-tooltip {
                                position: relative;
                                left: -50px;
                                top: -5px;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
