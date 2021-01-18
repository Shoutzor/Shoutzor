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
                <h2>Coming up</h2>
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
    export default {
        name: "dashboard-view"
    };
</script>
