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
                        :class="request.track.source"
                    >
                        <font-awesome-icon
                            class="mediasource-icon"
                            :icon="request.track.mediaicon"
                        ></font-awesome-icon>
                    </span>
                </td>
                <td>
                    <div>{{ request.track.title }}</div>
                    <div class="small text-muted">
                        <span v-for="(artist, index) in request.track.artist">
                            <span v-if="index != 0">, </span>
                            <router-link
                                :to="{ name:'artist', params:{ id: artist.id } }"
                            >{{artist.name}}</router-link>
                        </span>
                    </div>
                </td>
                <td>
                    <div>{{ request.user }}</div>
                </td>
                <td>
                    <div>{{ request.track.duration }}</div>
                </td>
                <td>
                    <div>{{ request.playtime }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        data() {
            return {
                queue: [
                    {
                        user: 'xorinzor',
                        playtime: '15:33',
                        track: {
                            title: 'Back in Black',
                            artist: [
                                { id: 0, name: 'ACDC'}
                            ],
                            duration: 120,
                            source: 'file',
                            mediaicon: ['fas', 'music']
                        }
                    },
                    {
                        user: 'xorinzor',
                        playtime: '15:33',
                        track: {
                            title: 'Never gonna give you up',
                            artist: [
                                { id: 0, name: 'Rick Astley'}
                            ],
                            duration: 120,
                            source: 'spotify',
                            mediaicon: ['fab', 'spotify']
                        }
                    },
                    {
                        user: 'Dygnus',
                        playtime: '15:35',
                        track: {
                            title: 'Livin la vida loca',
                            artist: [
                                { id: 0, name: 'Eddie Murphy'},
                                { id: 0, name: 'Antonio Banderas'}
                            ],
                            duration: 120,
                            source: 'soundcloud',
                            mediaicon: ['fab', 'soundcloud']
                        }
                    },
                    {
                        user: 'Kubushoofd',
                        playtime: '15:35',
                        track: {
                            title: 'Sweet but Psycho',
                            artist: [
                                { id: 0, name: 'Ava Max'}
                            ],
                            duration: 120,
                            source: 'youtube',
                            mediaicon: ['fab', 'youtube']
                        }
                    }
                ]
            }
        }
    }
</script>
