<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h2 class="category-header">Search Results</h2>
            <p v-if="loading">Loading search results for: {{ query }}</p>
            <p v-else-if="resultCount > 0">Displaying {{ resultCount }} search results for: {{ query }}</p>
            <p v-else>No search results found for: {{ query }}</p>
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
                <p v-if="result.search.media.length === 0">No results found</p>
                <div v-else class="list-group">
                    <div
                        v-for="media in result.search.media"
                        class="list-group-item d-flex flex-row p-2"
                    >
                        <media-icon :is_video="media.is_video" class="me-2"/>
                        <div>
                            <div class="text-white">{{ media.title }}</div>
                            <artist-list :artists="media.artists" class="small"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="category-header">Artists</h2>
                <p v-if="result.search.artists.length === 0">No results found</p>
                <div v-else class="list-group">
                    <div
                        v-for="artist in result.search.artists"
                        class="list-group-item d-flex flex-row p-2"
                    >
                        <img :src="artist.image || defaultArtistImage" class="avatar me-2" />
                        <div>
                            <div class="text-white">{{ artist.name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="category-header">Albums</h2>
                <p v-if="result.search.albums.length === 0">No results found</p>
                <div v-else class="list-group">
                    <div
                        v-for="album in result.search.albums"
                        class="list-group-item d-flex flex-row p-2"
                    >
                        <img :src="album.image || defaultAlbumImage" class="avatar me-2" />
                        <div>
                            <div class="text-white">{{ album.title }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</template>

<script>
import { defaultArtistImage, defaultAlbumImage } from "@js/config";
import {useQuery} from "@vue/apollo-composable";
import { SEARCH_QUERY } from "@graphql/search";
import BaseSpinner from "@components/BaseSpinner";
import ArtistList from "@components/ArtistList";
import MediaIcon from "@components/MediaIcon";

export default {
    name: "dashboard-view",
    components: {
        ArtistList,
        BaseSpinner,
        MediaIcon
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
        },
        resultCount() {
            let mediaResults = this.result?.search?.media?.length || 0;
            let artistResults = this.result?.search?.artists?.length || 0;
            let albumResults = this.result?.search?.albums?.length || 0;

            return mediaResults + artistResults + albumResults;
        }
    },
    watch: {
        '$route.query.q'() {
            this.doSearch();
        }
    },
    mounted() {
        this.doSearch();
    },
    methods: {
        doSearch() {
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
    }
};
</script>
