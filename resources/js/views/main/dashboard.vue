<template>
  <div>
    <div class="row row-cards">
      <div class="col-sm-12">
        <now-playing></now-playing>
      </div>
    </div>
    <div v-if="useQueue" class="row row-cards">
      <div class="col-sm-12">
        <h2 class="title-header">Coming up</h2>
        <div class="card">
          <div class="table-responsive">
            <coming-up></coming-up>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="row row-cards">
      <div class="col-sm-12">
        <h2 class="title-header">Current votes</h2>
        <current-votes></current-votes>
      </div>
    </div>
  </div>
</template>

<script>
import NowPlaying from "@js/components/main/media/NowPlaying";
import ComingUp from "@js/components/main/queue/ComingUp";
import CurrentVotes from "@js/components/main/vote/CurrentVotes";

export default {
  name: "dashboard-view",
  components: {
    CurrentVotes,
    NowPlaying,
    ComingUp
  },

  data() {
    return {
      useQueue: false
    };
  }
};
</script>

<style lang="scss" scoped>
.title-header {
  margin: 1rem 0 0.5rem;
  opacity: 0.25;
  font-size: 2rem;
}
</style>
