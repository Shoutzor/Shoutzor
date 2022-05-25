<template>
  <div>
    <div class="row row-cards">
      <div class="col-sm-12">
        <now-playing></now-playing>
      </div>
    </div>
    <div v-if="useQueue" class="row row-cards">
      <div class="col-sm-12">
        <h2 class="category-header">Coming up</h2>
        <div class="card">
          <div class="table-responsive">
            <coming-up></coming-up>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="row row-cards">
      <div class="col-sm-12">
        <h2 class="category-header">Current votes</h2>
        <vote-list></vote-list>
      </div>
    </div>
  </div>
</template>

<script>
import NowPlaying from "@components/NowPlaying";
import ComingUp from "@components/ComingUp";
import VoteList from "@js/components/main/vote/VoteList";

export default {
  name: "dashboard-view",
  components: {
    NowPlaying,
    ComingUp,
    VoteList
  },

  data() {
    return {
      useQueue: false
    };
  }
};
</script>
