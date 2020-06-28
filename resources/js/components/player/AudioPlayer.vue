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
            <div id="playbutton">
                <font-awesome-icon
                    :icon="['fas', 'play']"
                ></font-awesome-icon>
            </div>
        </div>
        <div class="volume-control">
            <font-awesome-icon
                :icon="['fas', 'volume-up']"
            ></font-awesome-icon>
        </div>
    </div>
</template>

<script>
    import History from '@js/models/History';

    export default {
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

        .media-info {
            padding-left: 10px;
            justify-content: flex-start;

            .artists {
                font-size: 0.75rem;
            }
        }

        .media-control {
            justify-content: center;

            #playbutton {
                width: 2.5rem;
                height: 2.5rem;
                background: $green;
                border-radius: 50%;
                text-align: center;

                & > svg {
                    width: 1.5rem;
                    height: 1.5rem;
                    margin-top: 0.5rem;
                }
            }
        }

        .volume-control {
            justify-content: flex-end;
            padding-right: 10px;
        }
    }
</style>
