<template>
    <table class="upload-manager table table-outline table-vcenter text-nowrap card-table">
        <thead>
            <tr>
                <th class="text-center w-1"></th>
                <th>File</th>
                <th>Size</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody v-if="(uploads && uploads.length > 0) || (files && files.length > 0)">
            <tr v-if="files.length > 0" v-for="(file, key) in files">
                <td class="text-center">
                    <span class="stamp upload-status stamp-md text-white mr-3">
                        <font-awesome-icon
                            class="status-icon"
                            :icon="['fas', 'upload']"
                        ></font-awesome-icon>
                    </span>
                </td>
                <td>
                    {{ file.name }}
                </td>
                <td>
                    {{ file.size }}
                </td>
                <td>
                    {{ file.status }}
                </td>
            </tr>
            <tr v-if="uploads.length > 0" v-for="(file, key) in uploads">
                <td class="text-center">
                    <span class="stamp upload-status stamp-md text-white mr-3">
                        <font-awesome-icon
                            class="status-icon"
                            :icon="['fas', 'film']"
                        ></font-awesome-icon>
                    </span>
                </td>
                <td>
                    {{ file.name }}
                </td>
                <td>
                    {{ file.size }}
                </td>
                <td>
                    {{ file.status }}
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="4">No files waiting for upload</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import Upload from '@js/models/Upload';

    export default {
        data(){
            return {
                files: []
            }
        },

        computed: {
            //TODO: change the name of the model, Upload is quite confusing as this is no longer a file to upload
            //TODO: but rather a file that is already uploaded and awaiting a free worker to process it.
            uploads: () => Upload.query().get()
        }
    }
</script>
