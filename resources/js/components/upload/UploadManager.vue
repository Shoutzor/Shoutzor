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
        <tbody v-if="files && files.length > 0">
            <tr v-for="(file, key) in files">
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
    import Axios from 'axios';

    export default {
        data(){
            return {
                files: []
            }
        },

        methods: {
            /*
             * Submits files to the server
             */
            submitFiles(){
                /*
                 * Initialize the form data
                 */
                let formData = new FormData();

                /*
                 * Iterate over any file sent over appending the files
                 * to the form data.
                 */
                for( var i = 0; i < this.files.length; i++ ){
                    let file = this.files[i];

                    formData.append('files[' + i + ']', file);
                }

                //Make the request to the POST /select-files URL
                Axios.post( '/select-files', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function(){
                    console.log('SUCCESS!!');
                })
                .catch(function(){
                    console.log('FAILURE!!');
                });
            },

            /*
             * Handles the uploading of files
             */
            handleFilesUpload(){
                let uploadedFiles = this.$refs.files.files;

                //Adds the uploaded file to the files array
                for( var i = 0; i < uploadedFiles.length; i++ ){
                    this.files.push( uploadedFiles[i] );
                }
            },

            /*
             * Removes a select file the user has uploaded
             */
            removeFile( key ){
                this.files.splice( key, 1 );
            }
        }
    }
</script>

<style lang="scss">

</style>
