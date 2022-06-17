<template>
    <div class="nowplaying">
        <div class="track-background">
            <img v-media-image-fallback class="album-image" :src="request?.media?.image || defaultMediaImage" alt="media image"/>
            <div class="album-overlay"></div>
        </div>
        <div class="track-content card card-aside">
            <img v-media-image-fallback alt="album image" class="album-image card-aside-column" :src="request?.media?.image || defaultMediaImage"/>

            <div class="track-info card-body d-flex flex-column mt-auto">
                <template v-if="request">
                    <h3>{{ request.media.title }}</h3>
                    <artist-list :artists="request.media.artists"></artist-list>

                    <div class="d-flex align-items-center mt-auto">
                        <div class="requested-by pl-3">
                            <small class="text-muted me-1">Requested by</small>
                            <template v-if="request.requested_by">{{ request.requested_by.username }}</template>
                            <template v-else>AutoDJ</template>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <p class="placeholder placeholder-wave placeholder-lg col-8"></p>
                    <span class="placeholder placeholder-wave placeholder-sm col-5"></span>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import "./NowPlaying.scss";

import ArtistList from "@components/ArtistList";
import UserList from "@components/UserList";
import BaseAlert from "@components/BaseAlert";

import {defaultMediaImage} from "@js/config";

export default {
    name: "now-playing",
    components: {
        BaseAlert,
        ArtistList,
        UserList
    },
    data() {
        return {
            defaultMediaImage
        }
    },
    computed: {
        request() { return this.mediaPlayer.lastPlayed; }
    }
}
</script>
