<template></template>

<script>
    import Axios from 'axios';

    export default {
        data(){
            return {
                files: []
            }
        },

        mounted() {
            this.$bus.on('upload-file', this.uploadFile);
        },

        beforeDestroy() {
            this.$bus.off('upload-file', this.uploadFile);
        },

        methods: {
            uploadFile(e) {
                e.dataTransfer.files.forEach(function(value, index) {
                    console.log("Upload file with axios:", value);
                });
            }
        }
    }
</script>
