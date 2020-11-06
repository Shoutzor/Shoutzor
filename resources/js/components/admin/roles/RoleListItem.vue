<template>
    <tr>
        <td>
            <input class="form-check-input m-0 align-middle" type="checkbox">
        </td>
        <td data-label="Role">
            {{ role.name }}
        </td>
        <td data-label="Description">
            {{ role.description }}
        </td>
        <td data-label="Actions">
            <div class="btn-list flex-nowrap">
                <router-link
                    :to="{
                        name: 'admin-roles-edit',
                        params: { roleId: role.id }
                    }"
                    class="btn btn-white">
                    Edit
                </router-link>
                <div class="dropdown">
                    <button class="btn btn-white dropdown-toggle align-text-top" data-boundary="viewport" data-toggle="dropdown">
                        Actions
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">
                            Clone
                        </a>
                        <a v-if="role.protected === false" class="dropdown-item" href="#">
                            Delete
                        </a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['role']
    }
</script>
