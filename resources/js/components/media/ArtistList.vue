<template>
    <div v-if="artists !== null" class="artists">
        <span v-for="(artist, index) in artists"
              :key="artist.id"
        >
            <template v-if="index != 0">, </template>
            <router-link
                :to="{ name:'artist', params:{ id: artist.id } }"
                class="artist"
            >{{ artist.name }}</router-link>
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
