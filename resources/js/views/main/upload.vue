<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <upload-area></upload-area>
                <upload-progress></upload-progress>
                <upload-failure></upload-failure>
                <task-overview class="mt-4"></task-overview>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "upload-view"
};
</script>
