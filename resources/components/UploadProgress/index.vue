<template>
    <div v-if="isUploading" class="card upload-progress">
        <div class="card-body">
            <div v-if="totalFiles > 0" class="h1 mb-3">
                Uploading files, {{ totalFiles }} pending
            </div>
            <div v-if="currentFile">
                <table class="table table-borderless card-table upload-info mb-2">
                    <tbody>
                    <tr>
                        <td><strong>Uploading:</strong></td>
                        <td>{{ currentFile }}</td>
                    </tr>
                    <tr>
                        <td><strong>Progress:</strong></td>
                        <td>{{ progress }}%</td>
                    </tr>
                    </tbody>
                </table>
                <div class="progress progress-sm">
                    <base-progressbar
                        :current-value="progress"
                        class="col d-flex flex-fill" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BaseProgressbar from "@components/BaseProgressbar";

export default {
    name: "upload-progress",
    components: {BaseProgressbar},
    computed: {
        totalFiles() {
            return this.uploadManager.files.length;
        },
        currentFile() { return this.uploadManager.currentFile; },
        progress() { return this.uploadManager.progress; },
        isUploading() { return this.uploadManager.isUploading; }
    }
}

</script>

<style lang="scss" scoped>
.progress-bar {
    width: var(--width);
}

.upload-info {
    flex-direction: column;

    strong {
        font-weight: 600;
    }
}
</style>
