<template>
    <table class="table table-hover table-vcenter text-nowrap card-table bg-dark">
        <thead>
        <tr>
            <th></th>
            <th>Media</th>
            <th>Album</th>
            <th>Requested by</th>
            <th>Duration</th>
            <th>Time played</th>
        </tr>
        </thead>
        <tbody v-if="history && history.length > 0">
            <tr v-for="request in historyFormatted">
                <td class="text-center mediatype-column">
                    <span
                        :class="request.media.is_video ? 'bg-orange' : 'bg-blue'"
                        class="avatar mediatype audio bg-azure-lt">
                        <component :is="request.media.is_video ? 'b-icon-film' : 'b-icon-music-note-beamed'" class="mediasource-icon"></component>
                    </span>
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
                        >{{ request.media.album.title}}</router-link></div>
                </td>
                <td>
                    <div v-if="request.users !== null && request.users.length > 0">{{ request.users.length }} user(s)</div>
                    <div v-else>AutoDJ</div>
                </td>
                <td>
                    <beautified-time :time="request.media.duration"></beautified-time>
                </td>
                <td>
                    <div>{{ request.played_at }}</div>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="5">No songs in queue</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import moment from "moment";

import BeautifiedTime from "@components/BeautifiedTime";
import ArtistList from "@components/ArtistList";
import UserList from "@components/UserList";

export default {
    name: 'history-table',

    components: {
        BeautifiedTime,
        ArtistList,
        UserList
    },

    props: {
        history: []
    },

    computed: {
        historyFormatted: function() {
            return this.history.filter(function(request) {
                request.played_at = moment(request.played_at).format("hh:mm:ss DD-MM-YYYY");
                return request;
            });
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
