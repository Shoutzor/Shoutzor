<template>
    <table class="coming-up table table-outline table-vcenter text-nowrap card-table">
        <thead>
        <tr>
            <td colspan="5" class="bg-light">
                <div class="small text-muted">Coming up</div>
            </td>
        </tr>
        <tr>
            <th class="text-center w-1"></th>
            <th>Song</th>
            <th>Requested by</th>
            <th>Duration</th>
            <th>Est. Time played</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="request in queue">
                <td class="text-center">
                    <span
                        class="stamp mediasource stamp-md bg-blue text-white mr-3"
                        :class="request.media.source.name"
                    >
                        <font-awesome-icon
                            class="mediasource-icon"
                            :icon="request.media.source.icon"
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
                    <div v-if="request.user !== null">{{ request.user }}</div>
                    <div v-if="request.user === null">AutoDJ</div>
                </td>
                <td>
                    <div>{{ request.media.duration }}</div>
                </td>
                <td>
                    <div>{{ request.playtime }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>

    import Request from '@/models/Request';

    export default {
        components: {
            Request
        },

        computed: {
            queue() {
                return Request.query().with(["media.artists|source", "user"]).get();
            }
        },

        mounted() {
            Request.insertOrUpdate({
                data: {
                    user_id: null,
                    playtime: '15:33',
                    media_id: 1,
                    media: {
                        id: 1,
                        title: 'Back in Black',
                        artists: [
                            {id: 1, name: 'ACDC', summary: "", image: ""}
                        ],
                        duration: 120,
                        source_id: 1,
                        source: {
                            id: 1,
                            name: 'file',
                            icon: ['fas', 'music']
                        }
                    },
                    requested_at: '2020-04-05 10:00'
                }
            });
        }
    }
</script>


<style scoped lang="scss">
    .coming-up {
        thead td {
            border-bottom: 1px solid rgb(226, 227, 227);
        }
    }

    .stamp.mediasource {
        font-size: 24px !important;

        &.file {
            background: $brand-color-none;
        }

        &.spotify {
            background: $brand-color-spotify;
        }

        &.youtube {
            background: $brand-color-youtube;
        }

        &.soundcloud {
            background: $brand-color-soundcloud;
        }
    }
</style>
