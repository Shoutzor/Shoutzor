<template>
    <table class="upload-manager table table-outline table-vcenter text-nowrap card-table">
        <thead>
        <tr>
            <th>File</th>
            <th>Size</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>
</template>

<script>
export default {
    name: "upload-table",

    data() {
        return {
            tasks: []
        }
    }
}
</script>
