<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h2 class="category-header">Search</h2>
            <p v-if="!loading">Displaying {{ result.search.media.length + result.search.artists.length + result.search.albums.length }} search results for: {{ query }}</p>
        </div>
    </div>
    <template v-if="loading">
        <div class="row row-cards">
            <div class="col-sm-12 text-center">
                <base-spinner />
            </div>
        </div>
    </template>
    <template v-else>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="category-header">Media</h2>
                <div class="list-group">
                    <div
                        v-for="media in result.search.media"
                        class="list-group-item d-flex flex-row p-2"
                    >
                        <span
                            :class="media.is_video ? 'bg-video text-white video' : 'bg-audio text-white audio'"
                            class="avatar mediatype me-2">
                            <component :is="media.is_video ? 'b-icon-film' : 'b-icon-music-note-beamed'"
                                       class="mediasource-icon"></component>
                        </span>
                        <div class="">
                            <div>{{ media.title }}</div>
                            <artist-list :artists="media.artists" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="category-header">Artists</h2>
                <div class="list-group">
                    <div
                        v-for="artist in result.search.artists"
                        class="list-group-item d-flex flex-row p-2"
                    >
                        <img :src="artist.image || defaultArtistImage" class="avatar me-2" />
                        <div class="">
                            <div>{{ artist.name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="category-header">Albums</h2>
                <div class="list-group">
                    <div
                        v-for="album in result.search.albums"
                        class="list-group-item d-flex flex-row p-2"
                    >
                        <img :src="album.image || defaultAlbumImage" class="avatar me-2" />
                        <div class="">
                            <div>{{ album.title }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</template>

<script>
import HistoryTable from "@components/HistoryTable";
import {useQuery} from "@vue/apollo-composable";
import BaseSpinner from "@components/BaseSpinner";
import { SEARCH_QUERY } from "@graphql/search";
import ArtistList from "@components/ArtistList";
import { defaultArtistImage, defaultAlbumImage } from "@js/config";

export default {
    name: "dashboard-view",
    components: {
        ArtistList,
        BaseSpinner,
        HistoryTable
    },
    data() {
        return {
            defaultArtistImage,
            defaultAlbumImage,
            loading: true,
            error: null,
            result: []
        }
    },
    computed: {
        query() {
            return this.$route.query?.q;
        }
    },
    mounted() {
        if(!this.query) {
            return;
        }

        this.loading = true;

        const { loading, error, result } = useQuery(SEARCH_QUERY, {
            q: this.query
        });

        console.dir(result);

        this.loading = loading;
        this.error = error;
        this.result = result;
    }
};
</script>
