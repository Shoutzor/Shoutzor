<template>
    <div class="nowplaying">
        <div class="track-background">
            <img v-if="error || loading || !request.media?.image" class="album-image" :src="defaultMediaImage" alt="default media image"/>
            <img v-else v-media-image-fallback class="album-image" :src="request.media.image" alt="media image"/>
            <div class="album-overlay"></div>
        </div>
        <div class="track-content card card-aside">
            <div v-if="error">
                <base-alert type="danger">Failed to load the last played request</base-alert>
            </div>
            <template v-else>
                <div v-if="loading" class="album-image card-aside-column placeholder"></div>
                <img v-else-if="error || !request.media?.image" class="album-image card-aside-column"
                     :src="defaultMediaImage" alt="default media image"/>
                <img v-else v-media-image-fallback alt="album image" class="album-image card-aside-column" :src="request.media.image"/>

                <div class="track-info card-body d-flex flex-column mt-auto">
                    <template v-if="loading">
                        <p class="placeholder placeholder-wave placeholder-lg col-8"></p>
                        <span class="placeholder placeholder-wave placeholder-sm col-5"></span>
                    </template>
                    <template v-else>
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
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import "./NowPlaying.scss";

import ArtistList from "@components/ArtistList";
import UserList from "@components/UserList";
import BaseAlert from "@components/BaseAlert";
import {useQuery} from "@vue/apollo-composable";
import {computed} from "vue";

import {defaultMediaImage} from "@js/config";
import {LASTPLAYED_REQUEST_QUERY} from "@constants/graphql/requests";

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
    setup() {
        const {result, loading, error} = useQuery(LASTPLAYED_REQUEST_QUERY);

        const request = computed(() => result?.value?.requests?.data[0] ?? {});

        return {
            result,
            loading,
            error,
            request
        }
    }
}
</script>
