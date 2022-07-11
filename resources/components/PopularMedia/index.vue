<template>
    <base-table description="Lists popular media file for the current artist or album">
        <template #header>
            <tr>
                <th scope="col" class="text-center"></th>
                <th scope="col">Media</th>
                <th scope="col">Duration</th>
            </tr>
        </template>

        <template v-slot>
            <template v-if="loading">
                <tr class="placeholder-glow">
                    <td class="text-center mediatype-column">
                        <span class="avatar mediatype placeholder"></span>
                    </td>
                    <td>
                        <span class="placeholder col-10"></span>
                    </td>
                    <td>
                        <span class="placeholder col-10"></span>
                    </td>
                </tr>
            </template>
            <template v-else-if="error">
                <tr>
                    <td colspan="4">Something went wrong while attempting to fetch the popular media</td>
                </tr>
            </template>
            <template v-else-if="items.length > 0">
                <tr v-for="media in items" :key="media.id">
                    <td class="text-center mediatype-column">
                        <media-icon :is_video="media.is_video" />
                    </td>
                    <td>
                        <div>{{ media.title }}</div>
                        <artist-list :artists="media.artists" class="small text-muted"></artist-list>
                    </td>
                    <td>
                        <beautified-time :seconds="media.duration"></beautified-time>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="4">No popular media found</td>
                </tr>
            </template>
        </template>
    </base-table>
</template>

<script>
import BaseTable from "@components/BaseTable";
import ArtistList from "@components/ArtistList";
import BeautifiedTime from "@components/BeautifiedTime";
import MediaIcon from "@components/MediaIcon";

import {useQuery } from "@vue/apollo-composable";
import {TOPMEDIA_QUERY} from "@graphql/media";

export default {
    name: "popular-media",

    components: {
        BaseTable,
        ArtistList,
        BeautifiedTime,
        MediaIcon
    },
    props: {
        artist: {
            type: String,
            required: false
        },
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
        items() {
            return this.result?.topMedia ?? [];
        }
    },
    mounted() {
        const {
            result,
            loading,
            error
        } = useQuery(TOPMEDIA_QUERY, () => {
            return {
                artist: this.artist,
                album: this.album,
                limit: 5
            };
        });

        this.loading = loading;
        this.error = error;
        this.result = result;
    }
}
</script>

<style lang="scss" scoped>
.table {
    thead td {
        border-bottom: 1px solid rgb(226, 227, 227);
    }

    .mediatype-column {
        width: 50px;
    }
}
</style>
