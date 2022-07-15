<template>
    <base-table description="Lists popular albums of the current artist" :hoverable="true">
        <template #header v-if="albums.length > 0">
            <tr>
                <th scope="col" class="image-column"></th>
                <th scope="col">Album</th>
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
                    <td colspan="2">Something went wrong while attempting to fetch the popular albums</td>
                </tr>
            </template>
            <template v-else-if="albums.length > 0">
                <tr
                    v-for="album in albums"
                    :key="album.id"
                    @click="onAlbumClick(album.id)"
                    class="clickable">
                    <td class="image-column">
                        <img alt="image" class="avatar" :src="album.image"/>
                    </td>
                    <td>
                        {{ album.title }}
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="2" class="text-center">No albums found</td>
                </tr>
            </template>
        </template>
    </base-table>
</template>

<script>
import BaseTable from "@components/BaseTable";

import {useQuery } from "@vue/apollo-composable";
import {TOPALBUMS_QUERY} from "@graphql/album";

export default {
    name: "popular-albums",

    components: {
        BaseTable
    },
    props: {
        artist: {
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
        albums() {
            return this.result?.topAlbums ?? [];
        }
    },
    mounted() {
        const {
            result,
            loading,
            error
        } = useQuery(TOPALBUMS_QUERY, () => {
            return {
                artist: this.artist,
                limit: 5
            };
        });

        this.loading = loading;
        this.error = error;
        this.result = result;
    },
    methods: {
        onAlbumClick(id) {
            this.$router.push({ name:'album', params:{ id: id } });
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
