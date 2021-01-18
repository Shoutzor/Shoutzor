<template>
    <div class="card upload-progress" v-if="status.totalFiles !== undefined && status.totalFiles > 0">
        <div class="card-body">
            <div class="h1 mb-3" v-if="status.totalFiles - 1 > 0">Uploading files, {{ status.totalFiles - 1 }} pending</div>
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
                    <div class="progress-bar bg-blue" :style="cssVars" role="progressbar" :aria-valuenow="status.progress" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">{{ status.progress }}% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                status: {}
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

<style scoped lang="scss">
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
