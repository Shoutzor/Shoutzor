<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <information-header :image="artist?.image || defaultArtistImage" class="artist-header">
                <template v-if="loading">
                    <p class="placeholder placeholder-wave placeholder-lg col-8"></p>
                    <span class="placeholder placeholder-wave placeholder-sm col-5"></span>
                </template>
                <template v-else>
                    <h3>{{ artist.name }}</h3>

                    <div class="d-flex align-items-center mt-auto" v-if="artist.summary">
                        {{ artist.summary }}
                    </div>
                </template>
            </information-header>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-sm-12 col-lg-6">
            <h2 class="category-header">Songs</h2>
            <popular-media :artist="id" />
        </div>
        <div class="col-sm-12 col-lg-6">
            <h2 class="category-header">Albums</h2>
        </div>
    </div>
</template>

<script>
import InformationHeader from "@components/InformationHeader";
import {defaultArtistImage} from "@js/config";
import PopularMedia from "@components/PopularMedia";
import {useQuery} from "@vue/apollo-composable";
import {ARTIST_QUERY} from "@graphql/artist";
import {watch} from "vue";

export default {
    name: "artist-view",
    components: {
        PopularMedia,
        InformationHeader
    },
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            defaultArtistImage,
            loading: true,
            result: null,
            refetch: null
        }
    },
    computed: {
        artist() {
            return this.result?.artist ?? null;
        }
    },
    mounted() {
        const {
            loading,
            result,
            refetch
        } = useQuery(ARTIST_QUERY, () => {
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
