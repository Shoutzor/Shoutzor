<template>
    <form action="" class="upload-area" enctype="multipart/form-data" method="post" @drop="onDrop">
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
        document.querySelector('body').addEventListener('dragover', this.onDragOver);
        document.querySelector('body').addEventListener('dragleave', this.onDragLeave);
    },

    beforeUnmount() {
        document.querySelector('body').removeEventListener('dragover', this.onDragOver);
        document.querySelector('body').removeEventListener('dragleave', this.onDragLeave);
    },

    methods: {
        onDragOver(e) {
            var dt = e.dataTransfer;
            if (dt.types && (dt.types.indexOf ? dt.types.indexOf('Files') !== -1 : dt.types.contains('Files'))) {
                document.querySelector(".upload-area").classList.add("showarea");
                if (this.dragTimer !== undefined) {
                    window.clearTimeout(this.dragTimer);
                }
            }
        },

        onDragLeave(e) {
            this.dragTimer = window.setTimeout(function () {
                document.querySelector(".upload-area").classList.remove("showarea");
            }, 25);
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
