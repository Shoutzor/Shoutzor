<template>
    <table class="table table-vcenter table-mobile-md card-table">
        <thead>
            <th class="w-1 tableHeaderCheckbox"></th>
            <th>Role</th>
            <th>Description</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <role-item
                v-for="(role, index) in roles"
                :key="role.id"
                :role="role"
            ></role-item>
        </tbody>
    </table>
</template>

<script>
import RoleItem from "@components/RoleItem";

export default {
    name: 'role-list',
    components: { RoleItem },
    props: {
        roles: {
            type: Array,
            required: true
        }
    }
}
</script>
