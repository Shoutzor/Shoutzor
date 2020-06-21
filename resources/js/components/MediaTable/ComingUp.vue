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
                <td class="text-center">
                        <span
                            v-if="request.media.is_video === true"
                            class="stamp mediatype video stamp-md bg-orange text-white mr-3"
                        >
                            <font-awesome-icon
                                class="mediasource-icon"
                                :icon="['fas', 'film']"
                            ></font-awesome-icon>
                        </span>
                        <span
                            v-else
                            class="stamp mediatype audio stamp-md bg-azure text-white mr-3"
                        >
                            <font-awesome-icon
                                class="mediasource-icon"
                                :icon="['fas', 'music']"
                            ></font-awesome-icon>
                        </span>
                </td>
                <td>
                    <div>{{ request.media.title }}</div>
                    <div class="small text-muted" v-if="request.media.artists !== null">
                            <span v-for="(artist, index) in request.media.artists"
                                  :key="artist.id"
                            >
                                <template v-if="index != 0">, </template>
                                <router-link
                                    :to="{ name:'artist', params:{ id: artist.id } }"
                                >{{artist.name}}</router-link>
                            </span>
                    </div>
                </td>
                <td>
                    <div v-if="request.user !== null">{{ request.user.name }}</div>
                    <div v-if="request.user === null">AutoDJ</div>
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
    import Request from '@/models/Request';
    import DateTime from "../date/DateTime";

    export default {
        components: {
            DateTime
        },

        computed: {
            queue: () => Request.query().with(["media.artists", "user"]).get()
        },

        created() {
            Request.api().fetch();
        }
    }
</script>


<style scoped lang="scss">
    .coming-up {
        thead td {
            border-bottom: 1px solid rgb(226, 227, 227);
        }
    }

    .stamp.mediatype {
        font-size: 24px !important;
    }
</style>
