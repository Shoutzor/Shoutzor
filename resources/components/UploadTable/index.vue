<template>
    <base-table
        class="upload-manager table table-outline table-vcenter text-nowrap card-table"
        description="Lists all uploaded files and their processing status">
        <template #header>
            <tr>
                <th scope="col">File</th>
                <th scope="col">Size</th>
                <th scope="col">Status</th>
            </tr>
        </template>
        <template v-slot>
            <template v-if="tasks && tasks.length > 0">
                <tr v-for="(file, key) in tasks" v-if="tasks.length > 0">
                    <td>
                        {{ file.name }}
                    </td>
                    <td>
                        {{ file.size }}
                    </td>
                    <td>
                        {{ file.status }}
                    </td>
                </tr>
            </template>
            <tr v-else>
                <td colspan="3">No files awaiting processing</td>
            </tr>
        </template>
    </base-table>
</template>

<script>
import BaseTable from "@components/BaseTable";

export default {
    name: "upload-table",
    components: {BaseTable},
    data() {
        return {
            tasks: []
        }
    }
}
</script>
