<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="comingup-header">History</h2>
                <div class="card mediaplayer">
                    <div class="table-responsive">
                        <requests-history></requests-history>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RequestsHistory from "@js/components/MediaTable/RequestsHistory";

export default {
    name: "dashboard-view", components: {
        RequestsHistory
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
