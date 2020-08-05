<template></template>

<script>
    import UploadService from "@js/services/UploadFilesService";

    export default {
        data(){
            return {
                files: [],
                isUploading: false,
                status: {
                    totalFiles: 0,
                    progress: 0,
                    currentFile: null,
                    failedFiles: []
                }
            }
        },

        watch: {
            files: function() {
                //When a file is uploading, it will be shifted from the this.files stack.
                //Therefor we need to increment it by 1
                if(this.isUploading === true) {
                    this.status.totalFiles = this.files.length + 1;
                } else {
                    this.status.totalFiles = this.files.length;
                }
            },
            status: {
                handler(val) {
                    //Whenever the upload status changes, emit an update event for the UploadProgress component
                    this.$bus.emit('upload-status', this.status);
                },
                deep: true
            }
        },

        mounted() {
            this.$bus.on('upload-file', this.uploadFiles);
        },

        beforeDestroy() {
            this.$bus.off('upload-file', this.uploadFiles);
        },

        methods: {
            uploadFiles(e) {
                //Set alias variable
                var addedFiles = e.dataTransfer.files;

                //Check if there's anything to upload
                if (addedFiles.length === 0) {
                    return;
                }

                //Iterate over the array of files to add to the upload queue
                addedFiles.forEach(file => this.files.push(file));
                this.status.totalFiles = this.files.length;

                //Check if we're already uploading a file
                if (this.isUploading === true) {
                    return;
                }

                //Start the upload of the first file
                this.uploadNextFile();
            },

            uploadNextFile() {
                //Grab the first file from the stack
                var currentFile = this.files.shift();

                //Update status variables
                this.updateStatusVariables();

                //Set uploading status to true
                this.isUploading = true;
                this.status.currentFile = currentFile.name;

                //Upload the file
                UploadService.upload(currentFile, event => {
                    this.status.progress = Math.round((100 * event.loaded) / event.total);
                })
                .then(response => {
                    //On success?
                    //this.message = response.data.message;
                })
                .catch(error => {
                    //Add the file to the failed uploads list to inform the user
                    this.status.failedFiles.push(
                        Object.assign(
                            {
                                filename: currentFile.name,
                                message: ""
                            },
                            //Parse the error response to create appropriate status output
                            this.parseError(error.response)
                        )
                    )
                })
                .finally(() => {
                    //Update status variables
                    this.updateStatusVariables();

                    //Check if there are any remaining files to upload
                    if(this.files.length > 0) {
                        //Start the upload of the next file.
                        this.uploadNextFile();
                    } else {
                        //We're finished with all queued files
                        this.isUploading = false;
                    }
                });
            },

            updateStatusVariables() {
                this.status.progress = 0;
                this.status.currentFile = null;
            },

            parseError(error) {
                //If the status code is 413, the payload is too large
                if(error.status === 413) {
                    return {
                        message: "The file is too large"
                    };
                }

                //Unknown error
                return {
                    message: "Unknown error"
                };
            }
        }
    }
</script>
