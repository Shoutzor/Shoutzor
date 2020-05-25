<template>
    <div class="col-sm-12 nowplaying" v-if="currentMedia">
        <div class="track-background">
            <img class="album-image" v-bind:src="albumImage" />
            <div class="album-overlay"></div>
        </div>
        <div class="track-content card card-aside">
            <img class="album-image card-aside-column" v-bind:src="albumImage" alt="album image" />
            <div class="track-info card-body d-flex flex-column mt-auto">
                <h3 style="font-size:20px;margin-bottom:1px;" v-if="currentMedia.media !== null">{{ currentMedia.media.title }}</h3>
                <p class="mb-2" style="font-size:18px;" v-if="currentMedia.media.artists !== null">
                    <span v-for="(artist, index) in currentMedia.media.artists"
                          :key="artist.id"
                    >
                        <template v-if="index != 0">, </template>
                        <router-link
                            :to="{ name:'artist', params:{ id: artist.id } }"
                        >{{artist.name}}</router-link>
                    </span>
                </p>
                <div class="d-flex align-items-center mt-auto">
                    <font-awesome-icon
                        class="upvote"
                        :icon="['fas', 'thumbs-up']"
                    ></font-awesome-icon>
                    <font-awesome-icon
                        class="downvote"
                        :icon="['fas', 'thumbs-down']"
                    ></font-awesome-icon>

                    <div class="requested-by pl-3">
                        <small class="text-muted">Requested by</small>
                        <div v-if="currentMedia.user !== null">{{ currentMedia.user.name}}</div>
                        <div v-if="currentMedia.user === null">AutoDJ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import History from '@/models/History';

    export default {
        data() {
            return {
                albumImage: '/images/album_temp_bg.jpg'
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

<style scoped lang="scss">
    .nowplaying {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;

        .track-background {
            z-index: -9999;

            .album-image {
                position: absolute;
                min-width: 100%;
                top: -115%;
                filter: blur(2px);

                @media (max-width: 47.98rem) {
                    min-width: 200%;
                    left: -50%;
                }
            }

            .album-overlay {
                position: absolute;
                width: 100%;
                height: 100%;
                background-repeat: repeat;
                background-position: 0px 0px;
                background-image: url('/images/nowplaying_overlay.png');
            }
        }

        .track-content {
            position: absolute;
            background: transparent;
            border: 0;
            box-shadow: none;
            top: 22px;
            left: 22px;
            flex-direction: row;

            .album-image {
                min-width: 200px;
                max-width: 200px;
                min-height: 200px;
                max-height: 200px;
                box-shadow: 0 0 2px #000;
            }

            .track-info {
                padding-bottom: 0;
                color: #FFF;
                text-shadow: 0 0 4px #000;

                .requested-by {
                    border-left: 1px solid #FFF;

                    .text-muted {
                        color: #929394 !important;
                    }
                }

                a, .upvote, .downvote {
                    color: #fff;

                    &:hover {
                        color: $gray;
                    }
                }

                .downvote {
                    margin: 0 10px;
                }
            }
        }
    }
</style>
