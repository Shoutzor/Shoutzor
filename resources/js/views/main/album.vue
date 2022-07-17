<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <information-header :image="album?.image || defaultAlbumImage" class="album-header">
                <template v-if="loading">
                    <p class="placeholder placeholder-wave placeholder-lg col-8"></p>
                    <span class="placeholder placeholder-wave placeholder-sm col-5"></span>
                </template>
                <template v-else>
                    <h3>{{ album.title }}</h3>

                    <div class="d-flex align-items-center mt-auto" v-if="album.summary">
                        {{ album.summary }}
                    </div>
                </template>
            </information-header>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-sm-12 col-lg-6">
            <h2 class="category-header">Most Requested</h2>
            <popular-media :album="id" />
        </div>
        <div class="col-sm-12 col-lg-6">
            <h2 class="category-header">Top Artists</h2>
            <popular-artists :album="id" />
        </div>
    </div>
</template>

<script>
import {useQuery} from "@vue/apollo-composable";
import {defaultAlbumImage} from "@js/config";
import InformationHeader from "@components/InformationHeader";
import PopularMedia from "@components/PopularMedia";
import {ALBUM_QUERY} from "@graphql/album";
import PopularArtists from "../../../components/PopularArtists";

export default {
    name: "album-view",
    components: {
        PopularArtists,
        InformationHeader,
        PopularMedia
    },
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            defaultAlbumImage,
            loading: true,
            result: null,
            refetch: null
        }
    },
    computed: {
        album() {
            return this.result?.album ?? null;
        }
    },
    mounted() {
        const {
            loading,
            result,
            refetch
        } = useQuery(ALBUM_QUERY, () => {
            return {
                id: this.id
            };
        });

        this.loading = loading;
        this.result = result;
        this.refetch = refetch;
    }
};
</script>
