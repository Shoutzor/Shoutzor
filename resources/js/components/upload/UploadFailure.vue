<template>
    <div v-if="failedFiles.length > 0" class="card upload-progress">
        <div class="card-body">
            <div class="h1">{{ failedFiles.length }} failed uploads</div>
            <table class="file-list table card-table">
                <thead>
                <tr>
                    <th>File</th>
                    <th>Reason</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="file in failedFiles" class="file">
                    <td>{{ file.filename }}</td>
                    <td>{{ file.message }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            failedFiles: {}
        }
    },

    mounted() {
        this.$bus.on('upload-status', this.uploadStatusUpdate);
    },

    beforeDestroy() {
        this.$bus.off('upload-status', this.uploadStatusUpdate);
    },

    methods: {
        uploadStatusUpdate(statusUpdate) {
            this.failedFiles = statusUpdate.failedFiles;
        }
    }
}

</script>

<style lang="scss" scoped>
</style>
