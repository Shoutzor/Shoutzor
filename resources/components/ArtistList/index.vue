<template>
    <div class="artists">
        <span v-for="(artist, index) in artists"
              :key="artist.id"
        >
            <template v-if="index !== 0">, </template>
            <router-link
                :to="{ name:'artist', params:{ id: artist.id } }"
                class="artist"
            >{{ artist.name }}</router-link>
        </span>
    </div>
</template>

<script>
import './ArtistList.css';

export default {
    name: 'artist-list',
    props: {
        artists: {
            type: Array,
            default: [],
            required: true
        }
    }
}
</script>
