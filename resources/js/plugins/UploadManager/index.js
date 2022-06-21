import axios from 'axios';
import { reactive } from 'vue';

class UploadManager {

    #echoClient

    #state

    constructor(echoClient) {
        this.#echoClient = echoClient;

        this.#state = reactive({
            isUploading: false,
            progress: 0,
            currentFile: null,
            files: [],
            failedFiles: []
        });
    }

    get isUploading() {
        return this.#state.isUploading;
    }

    get progress() {
        return this.#state.progress;
    }

    get currentFile() {
        return this.#state.currentFile;
    }

    get files() {
        return this.#state.files;
    }

    get totalFiles() {
        return this.files.length;
    }

    uploadFiles(addedFiles) {
        //Check if there's anything to upload
        if (addedFiles.length === 0) {
            return;
        }

        // Iterate over addedFiles to add them all to the upload queue
        // Required because addedFiles isn't actually an array, but a FileList object
        for (let i = 0; i < addedFiles.length; i++) {
            let file = addedFiles.item(i);
            this.#state.files.push(file);
        }

        //Check if we're already uploading a file
        if (this.isUploading === true) {
            return;
        }

        //Start the upload of the first file
        this.uploadNextFile();
    }

    uploadNextFile() {
        // Grab the first file from the stack
        var currentFile = this.#state.files.shift();

        // TODO check if file is a valid media format
        // These extensions should be dynamically fetched / updated (echo-subscription?)

        // Set uploading status to true
        this.#state.isUploading = true;
        this.#state.currentFile = currentFile.name;

        let formData = new FormData();
        formData.append("media", currentFile);

        // Upload the file
        // TODO replace with GraphQL upload mutation eventually
        axios.post("/upload", formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                },
                onUploadProgress: (event) => {
                    this.#state.progress = Math.floor((100 * event.loaded) / event.total);
                }
            })
            .then(response => {
                console.log("upload response: ", response);
                //On success?
                //this.message = response.data.message;
            })
            .catch(error => {
                //Add the file to the failed uploads list to inform the user
                this.#state.failedFiles.push(
                        Object.assign({
                            filename: currentFile.name,
                            message: ""
                        }, //Parse the error response to create appropriate status output
                        this.parseError(error.response))
                    );
            })
            .finally(() => {
                //Update status variables
                this.#state.progress = 0;
                this.#state.currentFile = null;

                //Check if there are any remaining files to upload
                if (this.totalFiles > 0) {
                    //Start the upload of the next file.
                    this.uploadNextFile();
                } else {
                    //We're finished with all queued files
                    this.#state.isUploading = false;
                }
            });
    }

    parseError(error) {
        var code = error.status;

        //401: Unauthorized
        if (code === 401) {
            return {
                message: "You need to be logged in to upload files"
            };
        }
        //413: the payload is too large
        else if (code === 413) {
            return {
                message: "The file is too large"
            };
        }
        //500: internal server error
        else if (code === 500) {
            return {
                message: "An error occured while uploading, please try again later"
            };
        }

        //Unknown error
        return {
            message: "Unknown error"
        };
    }
}

export const UploadManagerPlugin = {
    install: (app, options) => {
        app.config.globalProperties.uploadManager = new UploadManager(options.echoClient);
    }
}
