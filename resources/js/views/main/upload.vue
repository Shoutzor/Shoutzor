<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <upload-area></upload-area>

                <h1 class="mt-6">Upload manager</h1>
                <keep-alive>
                    <upload-manager></upload-manager>
                </keep-alive>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "upload-view"
    };
</script>
