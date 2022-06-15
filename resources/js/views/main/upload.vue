<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <upload-area></upload-area>
                <upload-progress></upload-progress>
                <upload-table></upload-table>
            </div>
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
