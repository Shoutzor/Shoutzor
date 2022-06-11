<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <!--        <now-playing></now-playing>-->
            </div>
        </div>
        <div class="row row-cards">
            <div v-if="useQueue" class="col-sm-12">
                <h2 class="category-header">Coming up</h2>
                <div class="card">
                    <div class="table-responsive">
                        <comingup-table :queue="queue" />
                    </div>
                </div>
            </div>
            <div v-else class="col-sm-12">
                <h2 class="category-header">Current votes</h2>
                <h2 class="category-header">Current votes</h2>
                <h2 class="category-header">Current votes</h2>
                <h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2><h2 class="category-header">Current votes</h2>

            </div>
        </div>
    </div>
</template>

<script>
import NowPlaying from "@components/NowPlaying";
import ComingupTable from "@components/ComingupTable";

export default {
    name: "dashboard-view",
    components: {
        NowPlaying,
        ComingupTable,
    },
    props: {
        useQueue: {
            type: Boolean,
            required: false,
            default: false
        },
        queue: {
            type: Array,
            required: false,
            default: []
        }
    }
};
</script>
