<template>
    <base-table
        class="table table-hover table-vcenter text-nowrap card-table bg-dark"
        description="Lists the media files that have been played previously">
        <template #header>
            <tr>
                <th scope="col"></th>
                <th scope="col">Media</th>
                <th scope="col">Album</th>
                <th scope="col">Requested by</th>
                <th scope="col">Duration</th>
                <th scope="col">Time played</th>
            </tr>
        </template>
        <template v-slot>
            <template v-if="history && history.length > 0">
                <tr v-for="request in history" :key="request.id">
                    <td class="text-center mediatype-column">
                        <media-icon :is_video="request.media.is_video" />
                    </td>
                    <td>
                        <div>{{ request.media.title }}</div>
                        <artist-list :artists="request.media.artists" class="small text-muted"></artist-list>
                    </td>
                    <td>
                        <div v-if="request.media.album !== null">
                            <router-link
                                :to="{ name:'album', params:{ id: request.media.album.id } }"
                                class="album"
                            >{{ request.media.album.title }}
                            </router-link>
                        </div>
                    </td>
                    <td>
                        <div v-if="request.requested_by">{{ request.requested_by.username }}</div>
                        <div v-else>AutoDJ</div>
                    </td>
                    <td>
                        <beautified-time :seconds="request.media.duration"></beautified-time>
                    </td>
                    <td>
                        <div>{{ request.played_at }}</div>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="5">No songs in queue</td>
                </tr>
            </template>
        </template>
    </base-table>
</template>

<script>
import {computed} from "vue";
import {useQuery} from "@vue/apollo-composable";
import {HISTORY_QUERY} from "@graphql/requests";
import BeautifiedTime from "@components/BeautifiedTime";
import ArtistList from "@components/ArtistList";
import UserList from "@components/UserList";
import BaseTable from "@components/BaseTable";
import MediaIcon from "@components/MediaIcon";

export default {
    name: 'history-table',

    components: {
        BaseTable,
        BeautifiedTime,
        ArtistList,
        UserList,
        MediaIcon
    },

    setup() {
        const {result, loading, error} = useQuery(HISTORY_QUERY);

        const history = computed(() => result?.value?.requests?.data ?? []);

        return {
            result,
            loading,
            error,
            history
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
