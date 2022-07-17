<template>
    <base-table description="Lists popular albums of the current artist" :hoverable="artists.length > 0">
        <template #header v-if="artists.length > 0">
            <tr>
                <th scope="col" class="image-column"></th>
                <th scope="col">Artist</th>
            </tr>
        </template>

        <template v-slot>
            <template v-if="loading">
                <tr class="placeholder-glow">
                    <td class="image-column">
                        <span class="avatar mediatype placeholder"></span>
                    </td>
                    <td>
                        <span class="placeholder col-12"></span>
                    </td>
                </tr>
            </template>
            <template v-else-if="error">
                <tr>
                    <td colspan="2">Something went wrong while attempting to fetch the popular artists</td>
                </tr>
            </template>
            <template v-else-if="artists.length > 0">
                <tr
                    v-for="artist in artists"
                    :key="artist.id"
                    @click="onArtistClick(artist.id)"
                    class="clickable">
                    <td class="image-column">
                        <img alt="image" class="avatar" :src="artist.image"/>
                    </td>
                    <td>
                        {{ artist.name }}
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="2" class="text-center">No artists found</td>
                </tr>
            </template>
        </template>
    </base-table>
</template>

<script>
import BaseTable from "@components/BaseTable";

import {useQuery } from "@vue/apollo-composable";
import {TOPARTISTS_QUERY} from "@graphql/artist";

export default {
    name: "popular-artists",

    components: {
        BaseTable
    },
    props: {
        album: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            result: [],
            loading: true,
            error: null
        };
    },
    computed: {
        artists() {
            return this.result?.topArtists ?? [];
        }
    },
    mounted() {
        const {
            result,
            loading,
            error
        } = useQuery(TOPARTISTS_QUERY, () => {
            return {
                album: this.album,
                limit: 5
            };
        });

        this.loading = loading;
        this.error = error;
        this.result = result;
    },
    methods: {
        onArtistClick(id) {
            this.$router.push({ name:'artist', params:{ id: id } });
        }
    }
}
</script>

<style lang="scss" scoped>
.table {
    .image-column {
        width: 50px;
    }
}
</style>
