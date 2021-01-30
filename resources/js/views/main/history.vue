<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="comingup-header">History</h2>
                <div class="card mediaplayer">
                    <div class="table-responsive">
                        <requests-table
                            :requests="history"
                        ></requests-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Request from '@js/models/Request';
    import RequestsTable from "@js/components/MediaTable/RequestsTable";

    export default {
        name: "dashboard-view",
        components: {
            RequestsTable
        },
        computed: {
            history: () => Request.query().where((r) => { return r.played_at !== null; }).with(["media.artists", "user"]).get()
        }
    };
</script>

<style scoped lang="scss">
    .comingup-header {
        margin: 1rem 0 0.5rem;
        opacity: 0.25;
        font-size: 2rem;
    }
</style>
