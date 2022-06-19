<template>
    <div v-if="status.totalFiles !== undefined && status.totalFiles > 0" class="card upload-progress">
        <div class="card-body">
            <div v-if="status.totalFiles > 1" class="h1 mb-3">
                Uploading files, {{ status.totalFiles - 1 }} pending
            </div>
            <div v-if="status.currentFile !== null">
                <table class="table table-borderless card-table upload-info mb-2">
                    <tbody>
                    <tr>
                        <td><strong>Uploading:</strong></td>
                        <td>{{ status.currentFile }}</td>
                    </tr>
                    <tr>
                        <td><strong>Progress:</strong></td>
                        <td>{{ status.progress }}%</td>
                    </tr>
                    </tbody>
                </table>
                <div class="progress progress-sm">
                    <div :aria-valuenow="status.progress" :style="cssVars" aria-valuemax="100" aria-valuemin="0"
                         class="progress-bar bg-blue" role="progressbar">
                        <span class="sr-only">{{ status.progress }}% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "upload-progress",

    data() {
        return {
            status: {}
        }
    },

    mounted() {
        this.emitter.on('upload-status', this.uploadStatusUpdate);
    },

    beforeUnmount() {
        this.emitter.off('upload-status', this.uploadStatusUpdate);
    },

    methods: {
        uploadStatusUpdate(statusUpdate) {
            this.status = statusUpdate;
            console.log(this.status);
        }
    },

    computed: {
        cssVars() {
            return {
                '--width': this.status.progress + '%'
            }
        }
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
