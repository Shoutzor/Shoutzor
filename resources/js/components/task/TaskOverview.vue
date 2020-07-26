<template>
    <table class="upload-manager table table-outline table-vcenter text-nowrap card-table">
        <thead>
            <tr>
                <th class="text-center w-1"></th>
                <th>File</th>
                <th>Size</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody v-if="tasks && tasks.length > 0">
            <tr v-if="tasks.length > 0" v-for="(file, key) in tasks">
                <td class="text-center">
                    <span class="stamp upload-status stamp-md text-white mr-3">
                        <font-awesome-icon
                            class="status-icon"
                            :icon="['fas', 'film']"
                        ></font-awesome-icon>
                    </span>
                </td>
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
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="4">No files awaiting processing</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import Task from '@js/models/Task';

    export default {
        data(){
            return {
            }
        },

        computed: {
            tasks: () => Task.query().get()
        }
    }
</script>
