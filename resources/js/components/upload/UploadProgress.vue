<template>
    <div class="card upload-progress" v-if="uploads && uploads.length > 0">
        <div class="card-body">
            <div class="h1 mb-3">Uploading files, 3 remaining</div>
            <div class="d-flex mb-2">
                <div>Task progress: 75%</div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-blue" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only">75% Complete</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                uploads: []
            }
        }
    }

</script>

<style scoped lang="scss">

</style>
