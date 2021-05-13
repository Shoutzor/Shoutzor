<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <div class="card">
                    <now-playing></now-playing>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="comingup-header">Coming up</h2>
                <div class="card mediaplayer">
                    <div class="table-responsive">
                        <coming-up></coming-up>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NowPlaying from "@js/components/MediaTable/NowPlaying";
import ComingUp from "@js/components/MediaTable/ComingUp";

export default {
    name: "dashboard-view",
    components: {
        NowPlaying,
        ComingUp
    }
};
</script>

<style lang="scss" scoped>
.comingup-header {
    margin: 1rem 0 0.5rem;
    opacity: 0.25;
    font-size: 2rem;
}
</style>
