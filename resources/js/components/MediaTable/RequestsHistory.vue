<template>
    <table class="table table-outline table-vcenter text-nowrap card-table">
        <thead>
        <tr>
            <th class="text-center"></th>
            <th>Media</th>
            <th>Requested by</th>
            <th>Duration</th>
            <th>Time played</th>
        </tr>
        </thead>
        <tbody v-if="history && history.length > 0">
        <tr v-for="request in historyFormatted">
            <td class="text-center mediatype-column">
                        <span
                            v-if="request.media.is_video === true"
                            class="avatar mediatype video bg-orange-lt"
                        >
                            <movie-icon class="mediasource-icon"></movie-icon>
                        </span>
                <span
                    v-else
                    class="avatar mediatype audio bg-azure-lt"
                >
                            <music-icon class="mediasource-icon"></music-icon>
                        </span>
            </td>
            <td>
                <div>{{ request.media.title }}</div>
                <artist-list :artists="request.media.artists" class="small text-muted"></artist-list>
            </td>
            <td>
                <div v-if="request.user !== null">{{ request.user.username }}</div>
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
import Request from "@js/models/Request";
import BeautifiedTime from "@js/components/date/BeautifiedTime";

export default {
    components: {
        BeautifiedTime
    },
    computed: {
        history: () => Request.query().where((r) => {
            return r.played_at !== null;
        }).orderBy('played_at', 'desc').with(["media.artists", "user"]).get(),

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
