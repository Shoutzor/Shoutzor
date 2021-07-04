<template>
  <div class="mediaVotes">
    <div class="row row-deck row-cards">
      <div v-for="vote in votes" class="col-sm-6 col-lg-3">
        <vote-card v-bind:media="vote"></vote-card>
      </div>
    </div>
  </div>
</template>

<script>
import VoteCard from "./VoteCard";
export default {
  components: {VoteCard},

  data() {
    return {
      votes: [
        {
          title: 'Ghosts \'n stuff',
          artist: 'Deadmau5',
          album: [{
            image: 'album_temp_bg.jpg'
          }],
          votes: 10,
          percentage: 62
        },
        {
          title: 'Right Round',
          artist: 'Deadmau5',
          album: [{
            image: 'album_temp_bg.jpg'
          }],
          votes: 4,
          percentage: 25
        },
        {
          title: 'I kissed a girl (and I liked it)',
          artist: 'Katy Perry',
          album: [{
            image: 'album_cover_placeholder.jpg'
          }],
          votes: 2,
          percentage: 12.5
        }
      ]
    };
  },

  computed: {
  }
}
</script>

<style lang="scss" scoped>

</style>