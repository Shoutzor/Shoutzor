<template>
    <base-table>
        <template #header>
            <tr>
                <th class="text-center"></th>
                <th>Media</th>
                <th>Requested by</th>
                <th>Duration</th>
            </tr>
        </template>

        <template v-slot>
            <template v-if="loading">
                <tr class="placeholder-glow">
                    <td class="text-center mediatype-column">
                        <span class="avatar mediatype placeholder"></span>
                    </td>
                    <td class="w-75">
                        <div><span class="placeholder col-7"></span></div>
                        <span class="placeholder placeholder-xs col-4"></span>
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
                    <td colspan="4">Something went wrong while attempting to fetch the queue</td>
                </tr>
            </template>
            <template v-else-if="queue.length > 0">
                <tr v-for="request in queue" :key="request.id">
                    <td class="text-center mediatype-column">
                        <span v-if="!!request.media.is_video" class="avatar mediatype video bg-orange-lt">
                            <b-icon-film class="mediasource-icon"></b-icon-film>
                        </span>
                        <span v-else class="avatar mediatype audio bg-azure-lt">
                            <b-icon-music-note-beamed class="mediasource-icon"></b-icon-music-note-beamed>
                        </span>
                    </td>
                    <td>
                        <div>{{ request.media.title }}</div>
                        <artist-list :artists="request.media.artists" class="small text-muted"></artist-list>
                    </td>
                    <td>
                        <div v-if="request.requested_by !== null">{{ request.requested_by.username }}</div>
                        <div v-else>AutoDJ</div>
                    </td>
                    <td>
                        <beautified-time :seconds="request.media.duration"></beautified-time>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="4">No songs in queue</td>
                </tr>
            </template>
        </template>
    </base-table>
</template>

<script>
import BaseTable from "@components/BaseTable";
import ArtistList from "@components/ArtistList";
import BeautifiedTime from "@components/BeautifiedTime";

import {useQuery} from "@vue/apollo-composable";
import {computed} from "vue";
import {COMINGUP_QUERY} from "@graphql/requests";

export default {
    name: "comingup-table",

    components: {
        BaseTable,
        ArtistList,
        BeautifiedTime
    },
    setup() {
        const {result, loading, error} = useQuery(COMINGUP_QUERY);

        const queue = computed(() => result?.value?.requests?.data ?? []);

        return {
            result,
            loading,
            error,
            queue
        }
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

        .avatar.mediatype {
            font-size: 24px !important;
        }
    }
}
</style>
