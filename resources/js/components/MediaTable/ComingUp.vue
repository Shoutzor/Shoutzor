<template>
    <table class="coming-up table table-outline table-vcenter text-nowrap card-table">
        <thead>
        <tr>
            <th class="text-center w-1"></th>
            <th>Media</th>
            <th>Requested by</th>
            <th>Duration</th>
            <th>Est. Time played</th>
        </tr>
        </thead>
        <tbody v-if="queue && queue.length > 0">
            <tr v-for="request in queue">
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
    import Request from '@js/models/Request';
    import DateTime from "../date/DateTime";

    export default {
        components: {
            DateTime
        },

        computed: {
            queue: () => Request.query().with(["media.artists", "user"]).get()
        }
    }
</script>


<style scoped lang="scss">
    .coming-up {
        thead td {
            border-bottom: 1px solid rgb(226, 227, 227);
        }

        .mediatype-column {
            width: 50px;
        }
    }

    .avatar.mediatype {
        font-size: 24px !important;
    }
</style>
