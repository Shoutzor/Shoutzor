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
        <tbody v-if="requests && requests.length > 0">
            <tr v-for="request in requests">
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
                    <artist-list class="small text-muted" :artists="request.media.artists"></artist-list>
                </td>
                <td>
                    <div v-if="request.user !== null">{{ request.user.username }}</div>
                    <div v-else>AutoDJ</div>
                </td>
                <td>
                    <date-time :time="request.media.duration"></date-time>
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
     import DateTime from "@js/components/date/DateTime";

    export default {
        components: {
            DateTime
        },

        props: {
            requests: Array
        }
    }
</script>


<style scoped lang="scss">
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
