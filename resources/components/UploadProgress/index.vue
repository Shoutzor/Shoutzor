<template>
    <div class="card upload-progress mb-3">
        <div class="card-body">
            <template v-if="isUploading">
                <div v-if="totalFiles > 0" class="h1 mb-3">
                    Uploading files, {{ totalFiles }} pending
                </div>
                <div v-if="currentFile">
                    <p><strong>Uploading:</strong> {{ currentFile }}</p>
                    <p><strong>Progress:</strong> {{ progress }}%</p>

                    <div class="progress progress-sm">
                        <base-progressbar
                            :current-value="progress"
                            class="col d-flex flex-fill" />
                    </div>
                </div>
            </template>
            <template v-else>
                <div>
                    <p><strong>Status: </strong> No uploads pending</p>
                </div>
            </template>
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
