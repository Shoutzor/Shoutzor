<template>
    <table class="table table-outline table-vcenter text-nowrap card-table">
        <thead>
        <tr>
            <th class="text-center"></th>
            <th>Media</th>
            <th>Requested by</th>
            <th>Duration</th>
            <th>Est. Time played</th>
        </tr>
        </thead>
        <tbody v-if="queue && queue.length > 0">
        <tr v-for="request in queueWithPlaytime">
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
                <div>{{ request.playtime }}</div>
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
import Request from "@js/models/Request";
import BeautifiedTime from "@js/components/date/BeautifiedTime";
import moment from "moment";

export default {
    components: {
        BeautifiedTime
    },
    computed: {
        lastPlayed: () => Request.query().where((r) => {
            return r.played_at !== null;
        }).orderBy('played_at', 'desc').limit(1).with(["media"]).first(),
        queue: () => Request.query().where((r) => {
            return r.played_at === null;
        }).orderBy('requested_at', 'asc').with(["media.artists", "user"]).get(),

        queueWithPlaytime: function() {
            let lastPlayedDate;
            let now = moment();

            //Check if something has been played yet
            if(this.lastPlayed === null) {
                lastPlayedDate = now;
            }
            else {
                //Calculate the end-time of the song that has been played last
                lastPlayedDate = moment(this.lastPlayed.played_at).add(this.lastPlayed.media.duration, 'seconds');

                //If the end-time is in the past, fast-forward to this point in time.
                if(lastPlayedDate.isBefore()) {
                    lastPlayedDate = now;
                }
            }

            return this.queue.filter(function(item) {
                item.playtime = lastPlayedDate.format("hh:mm:ss");
                lastPlayedDate.add(item.media.duration, 'seconds');
                return item;
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
