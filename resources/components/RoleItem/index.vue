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
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Edit
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <li><a class="dropdown-item" href="#" @click.prevent="$emit('role-clone', role.id)">Clone</a></li>
                    <li><a v-if="role.protected === false" class="dropdown-item" href="#" @click.prevent="$emit('role-delete', role.id)">Delete</a></li>
                </ul>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    name: 'role-item',

    props: {
        role: {
            type: Object,
            required: true
        }
    },

    emits: ['role-clone', 'role-delete']
}
</script>
