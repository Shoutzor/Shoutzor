<template>
    <form action="" class="upload-area" enctype="multipart/form-data" method="post" @drop="onDrop">
        <div class="box_input">
            <b-icon-cloud-upload class="box_icon"></b-icon-cloud-upload>
            <input id="file" class="box_file" data-multiple-caption="{count} files selected" multiple name="files[]"
                   type="file" @change="onFileSelect"/>
            <label for="file">
                <strong>Choose a file</strong>
                <span class="box_dragndrop"> or drag it here</span>
            </label>
        </div>
    </form>
</template>

<script>
export default {
    name: "upload-area",

    data: () => ({
        dragTimer: null
    }),

    mounted() {
        this.emitter.on('dragover', this.onDragOver);
        this.emitter.on('dragleave', this.onDragLeave);
    },

    beforeUnmount() {
        this.emitter.off('dragover', this.onDragOver);
        this.emitter.off('dragleave', this.onDragLeave);
    },

    methods: {
        onDragOver(e) {
            var dt = e.dataTransfer;
            if (dt.types && (dt.types.indexOf ? dt.types.indexOf('Files') !== -1 : dt.types.contains('Files'))) {
                document.querySelector(".upload-area[" + this.$options._scopeId + "]").classList.add("showarea");
                if (this.dragTimer !== undefined) {
                    window.clearTimeout(this.dragTimer);
                }
            }
        },

        onDragLeave(e) {
            this.dragTimer = window.setTimeout(function () {
                document.querySelector(".upload-area[" + this.$options._scopeId + "]").classList.remove("showarea");
            }, 25);
        },

        onDrop(e) {
            e.preventDefault();
            var dt = e.dataTransfer;
            if (dt.types && (dt.types.indexOf ? dt.types.indexOf('Files') !== -1 : dt.types.contains('Files'))) {
                this.emitter.emit('upload-file', e.dataTransfer.files);
            }
        },

        onFileSelect(e) {
            if (e.target.files !== undefined) {
                this.emitter.emit('upload-file', e.target.files);
            }
        }
    }
}
</script>

<style lang="scss" scoped>
/* credits for styling: https://css-tricks.com/drag-and-drop-file-uploading/ */

.upload-area {
    padding: 25px 20px;
    background-color: rgba(1, 1, 1, 0.1);
    outline: 2px dashed rgba(1, 1, 1, 0.4);
    outline-offset: -10px;

    .box_input {
        text-align: center;
        color: rgba(255, 255, 255, 0.4);

        .box_icon {
            width: 100%;
            height: 50px;
            display: block;
            margin-bottom: 10px;
            stroke-width: 1;
        }

        .box_file {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        label {
            font-size: 23px;
            max-width: 80%;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: inline-block;
            overflow: hidden;

            strong {
                font-weight: 600;
                color: rgba(255, 255, 255, 0.7);
            }

            .box_dragndrop {
                display: inline;
            }
        }
    }
}
</style>
