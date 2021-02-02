<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="search-header">%i search results for "{{ $route.query.q }}"</h2>
            </div>
        </div>
        <div class="row row-cards searchresults">
            <div class="col-sm-12 result-wrapper">
                <div class="card result">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ComingUp from "@js/components/MediaTable/ComingUp";

    export default {
        name: "search-view",
        components: {
            ComingUp
        }
    };
</script>

<style scoped lang="scss">
    .search-header {
        margin: 0 0 0.5rem;
        opacity: 0.25;
        font-size: 2rem;
    }
</style>
