<template>
    <div class="nowplaying">
        <div class="track-background">
            <img class="album-image" :src="media.image" />
            <div class="album-overlay"></div>
        </div>
        <div class="track-content card card-aside">
            <img alt="album image" class="album-image card-aside-column" :src="media.image" />
            <div class="track-info card-body d-flex flex-column mt-auto">
                <h3>{{ media.title }}</h3>
                <artist-list :artists="media.artists"></artist-list>

                <div class="d-flex align-items-center mt-auto">
                    <div class="requested-by pl-3">
                        <small class="text-muted me-1">Requested by</small>
                        <template v-if="requestedBy.length > 0"><user-list :users="requestedBy"></user-list></template>
                        <template v-else>AutoDJ</template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "./NowPlaying.scss";

import ArtistList from "@components/ArtistList";
import UserList from "@components/UserList";

export default {
    data() {
        return {
            loading: false,
            media: {}
        }
    },
    components: {
        ArtistList,
        UserList
    },
    props: {
        media: {
            type: Object,
            required: true,
            default: {}
        },
        requestedBy: {
            type: Array,
            required: false,
            default: []
        }
    }
}
</script>
