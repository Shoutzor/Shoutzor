<template>
    <base-table>
        <template #header>
            <tr>
                <th class="text-center"></th>
                <th>Media</th>
                <th>Requested by</th>
                <th>Duration</th>
                <th>Est. Time played</th>
            </tr>
        </template>

        <template v-slot v-if="queue.length > 0">
            <tr v-for="request in queueWithPlaytime">
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
        </template>
        <template v-slot v-else>
            <tr>
                <td colspan="5">No songs in queue</td>
            </tr>
        </template>
    </base-table>
</template>

<script>
import moment from "moment";

import BaseTable from "@components/BaseTable";
import ArtistList from "@components/ArtistList";
import BeautifiedTime from "@components/BeautifiedTime";

export default {
    components: {
        BaseTable,
        ArtistList,
        BeautifiedTime
    },

    props: {
        lastPlayed: [],
        queue: [],
    },
    computed: {
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
