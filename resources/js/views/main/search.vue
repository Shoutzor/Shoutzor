<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h2 class="category-header">Search</h2>
            <p v-if="!query">Please provide a search query first</p>
            <p v-else-if="loading">Loading search results for: <strong>{{ query }}</strong></p>
            <p v-else-if="resultCount > 0">Displaying <strong>{{ resultCount }}</strong> search results for: <strong>{{ query }}</strong></p>
            <p v-else>No search results found for: <strong>{{ query }}</strong></p>
            <p>
                If you want to search for part of a word, make sure to include an asterisk (*) after it.<br />
                For example, searching for "<strong>anim*</strong>" would match "<strong>animal</strong>" or "<strong>animation</strong>".
            </p>
            <p>Additionally you can prepend a word with "+" or "-"; Where + indicates that a word is required in the result, and - indicates that a word should not be part of the result.</p>
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
        <template v-if="resultCount > 0">
            <div class="row row-cards">
                <div class="col-sm-12">
                    <h2 class="category-header">Media</h2>
                    <p v-if="!result?.search?.media?.length">No results found</p>
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
                            <request-button :media="media" class="ms-auto" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cards">
                <div class="col-sm-12">
                    <h2 class="category-header">Artists</h2>
                    <p v-if="!result?.search?.artists?.length">No results found</p>
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
                    <p v-if="!result?.search?.albums?.length">No results found</p>
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
</template>

<script>
import { defaultArtistImage, defaultAlbumImage } from "@js/config";
import {useQuery} from "@vue/apollo-composable";
import { SEARCH_QUERY } from "@graphql/search";
import BaseSpinner from "@components/BaseSpinner";
import ArtistList from "@components/ArtistList";
import MediaIcon from "@components/MediaIcon";
import RequestButton from "@components/RequestButton";

export default {
    name: "dashboard-view",
    components: {
        RequestButton,
        ArtistList,
        BaseSpinner,
        MediaIcon
    },
    data() {
        return {
            defaultArtistImage,
            defaultAlbumImage,
            loading: false,
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
                this.result = [];
                return;
            }

            this.loading = true;

            const { loading, error, result } = useQuery(SEARCH_QUERY, {
                q: this.query
            });

            this.loading = loading;
            this.error = error;
            this.result = result;
        }
    }
};
</script>
