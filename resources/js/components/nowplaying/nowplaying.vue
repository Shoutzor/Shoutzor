<template>
    <div class="card mediaplayer">
        <div class="table-responsive">
            <div class="col-sm-12 nowplaying">
                <div class="track-background">
                    <img class="album-image" v-bind:src="albumImage" />
                    <div class="album-overlay"></div>
                </div>
                <div class="track-content card card-aside">
                    <img class="album-image card-aside-column" v-bind:src="albumImage" alt="album image" />
                    <div class="track-info card-body d-flex flex-column mt-auto">
                        <h3 style="font-size:20px;margin-bottom:1px;">{{ trackTitle }}</h3>
                        <p class="mb-2" style="font-size:18px;">
                            <span v-for="(artist, index) in trackArtist">
                                <span v-if="index != 0">, </span>
                                <router-link
                                    :to="{ name:'artist', params:{ id: artist.id } }"
                                >{{artist.name}}</router-link>
                            </span>
                        </p>
                        <div class="d-flex align-items-center mt-auto">
                            <a href="#" class="upvote"><i class="fa fa-thumbs-up"></i></a>
                            <a href="#" class="downvote mx-3"><i class="fa fa-thumbs-down"></i></a>

                            <div class="requested-by pl-3">
                                <small class="text-muted">Requested by</small>
                                <div>{{ requester }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <comingup></comingup>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                albumImage: '/images/album_temp_bg.jpg',
                trackTitle: 'Ghosts n\' Stuff',
                trackArtist: [
                    { id: 0, name: 'Deadmau5' },
                    { id: 1, name: 'Test' }
                ],
                requester: 'Someone'
            }
        }
    }
</script>
