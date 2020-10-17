<template>
    <table class="media-results table table-outline table-vcenter text-nowrap card-table">
        <thead>
        <tr>
            <th class="text-center w-1"></th>
            <th>Media</th>
            <th>Duration</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody v-if="queue && queue.length > 0">
            <tr v-for="media in results">
                <td class="text-center">
                        <span
                            v-if="media.source"
                            class="stamp mediasource stamp-md text-white mr-3"
                            :class="media.source.identifier"
                        >
                            <font-awesome-icon
                                class="mediasource-icon"
                                :icon="media.source.icon"
                            ></font-awesome-icon>
                        </span>
                        <span
                            v-else
                            class="stamp mediasource unknown stamp-md text-white mr-3"
                        >
                            <font-awesome-icon
                                class="mediasource-icon"
                                :icon="['fas', 'question']"
                            ></font-awesome-icon>
                        </span>
                </td>
                <td>
                    <div>{{ media.title }}</div>
                    <div class="small text-muted" v-if="media.artists !== null">
                            <span v-for="(artist, index) in media.artists"
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
                    <date-time :time="media.duration"></date-time>
                </td>
                <td>
                    <p>request button placeholder</p>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="5">No results</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        computed: {
            queue: () => Media.query().with(["artists", "user"]).get()
        },

        mounted() {
            //Search query is probably done by the container of the component?
        }
    }
</script>


<style scoped lang="scss">
    .media-results {
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
