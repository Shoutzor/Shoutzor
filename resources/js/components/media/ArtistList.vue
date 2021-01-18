<template>
    <div class="artists" v-if="artists !== null">
        <span v-for="(artist, index) in artists"
              :key="artist.id"
        >
            <template v-if="index != 0">, </template>
            <router-link
                class="artist"
                :to="{ name:'artist', params:{ id: artist.id } }"
            >{{artist.name}}</router-link>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['artists']
    }
</script>

<style lang="scss">
    a.artist {
        color: inherit;
    }
</style>
