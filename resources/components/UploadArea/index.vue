<template>
    <form action="" class="upload-area" enctype="multipart/form-data" method="post">
        <div class="box_input">
            <b-icon-cloud-upload class="box_icon"></b-icon-cloud-upload>

            <input
                id="file"
                class="box_file"
                data-multiple-caption="{count} files selected"
                multiple
                name="files[]"
                type="file"
                @change="onFileSelect" />

            <label for="file">
                <strong>Choose a file</strong>
                <span class="box_dragndrop"> or drag it here</span>
            </label>
        </div>
    </form>
</template>

<script>
import "./UploadArea.scss";

export default {
    name: "upload-area",

    data: () => ({
        dragTimer: null
    }),

    mounted() {
        document.querySelector('.upload-area').addEventListener('dragover', this.onDragOver);
        document.querySelector('.upload-area').addEventListener('dragleave', this.onDragLeave);
        document.querySelector('.upload-area').addEventListener('drop', this.onDrop);
    },

    beforeUnmount() {
        document.querySelector('.upload-area').removeEventListener('dragover', this.onDragOver);
        document.querySelector('.upload-area').removeEventListener('dragleave', this.onDragLeave);
        document.querySelector('.upload-area').removeEventListener('drop', this.onDrop);
    },

    methods: {
        onDragOver(e) {
            var dt = e.dataTransfer;
            if (dt.types && (dt.types.indexOf ? dt.types.indexOf('Files') !== -1 : dt.types.contains('Files'))) {
                e.preventDefault();
                document.querySelector(".upload-area").classList.add("showarea");
            }
        },

        onDragLeave(e) {
            document.querySelector(".upload-area").classList.remove("showarea");
        },

        onDrop(e) {
            e.preventDefault();
            var dt = e.dataTransfer;
            if (dt.types && (dt.types.indexOf ? dt.types.indexOf('Files') !== -1 : dt.types.contains('Files'))) {
                this.uploadManager.uploadFiles(e.dataTransfer.files);
            }
        },

        onFileSelect(e) {
            if (e.target.files !== undefined) {
                this.uploadManager.uploadFiles(e.target.files);
            }
        }
    }
}
</script>
