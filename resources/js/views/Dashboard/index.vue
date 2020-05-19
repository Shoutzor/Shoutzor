<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <div class="card mediaplayer">
                <div class="table-responsive">
                    <now-playing></now-playing>
                    <coming-up></coming-up>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "dashboard-view"
    };
</script>
