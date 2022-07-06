<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <information-header :image="artist?.image || defaultArtistImage" class="artist-header">
                <template v-if="artist">
                    <h3>{{ artist.name }}</h3>

                    <div class="d-flex align-items-center mt-auto" v-if="artist.summary">
                        {{ artist.summary }}
                    </div>
                </template>
                <template v-else>
                    <p class="placeholder placeholder-wave placeholder-lg col-8"></p>
                    <span class="placeholder placeholder-wave placeholder-sm col-5"></span>
                </template>
            </information-header>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-sm-12 col-lg-6">
            <h2 class="category-header">Songs</h2>
        </div>
        <div class="col-sm-12 col-lg-6">
            <h2 class="category-header">Albums</h2>
        </div>
    </div>
</template>

<script>
import InformationHeader from "@components/InformationHeader";
import {defaultArtistImage} from "@js/config";

export default {
    name: "artist-view",
    components: {
        InformationHeader
    },
    data() {
        return {
            defaultArtistImage
        }
    }
};
</script>
