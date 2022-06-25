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

            <label v-if="dragOver" for="file">
                <span class="box_dragndrop">Drop your file here</span>
            </label>
            <label v-else for="file">
                <span class="action">Choose a file</span>
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
        dragTimer: null,
        dragOver: false
    }),

    mounted() {
        document.querySelector('body').addEventListener('dragover', this.onDragOver);
        document.querySelector('body').addEventListener('dragleave', this.onDragLeave);
        document.querySelector('.upload-area').addEventListener('drop', this.onDrop);
    },

    beforeUnmount() {
        document.querySelector('body').removeEventListener('dragover', this.onDragOver);
        document.querySelector('body').removeEventListener('dragleave', this.onDragLeave);
        document.querySelector('.upload-area').removeEventListener('drop', this.onDrop);
    },

    methods: {
        onDragOver(e) {
            e.preventDefault();

            // Prevent running the queryselector + classlist modifiers on every single dragover event
            // which is basically triggered on every pixel movement
            if(this.dragOver) {
                return;
            }

            this.dragOver = true;
            document.querySelector(".upload-area").classList.add("showarea");
        },

        onDragLeave(e) {
            // Only trigger when the dragleave event has no related target (ie: left the <body>)
            if(e.relatedTarget) {
                return;
            }

            this.dragOver = false;
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
