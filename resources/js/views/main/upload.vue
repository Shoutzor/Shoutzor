<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <upload-area></upload-area>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h2 class="category-header">File Uploads</h2>
            <upload-progress></upload-progress>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-sm-12">
            <upload-table></upload-table>
        </div>
    </div>
</template>

<script>
import UploadArea from "@components/UploadArea";
import UploadProgress from "@components/UploadProgress";
import UploadTable from "@components/UploadTable";

export default {
    name: "upload-view",

    components: {
        UploadProgress,
        UploadArea,
        UploadTable
    }
};
</script>
