/**
 * Credits: https://github.com/bezkoder/vue-upload-files
 */
import http from "@js/http-common";

class UploadFilesService {
    upload(file, onUploadProgress) {
        let formData = new FormData();

        formData.append("file", file);

        return http.post("/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
            onUploadProgress
        });
    }
}

export default new UploadFilesService();
