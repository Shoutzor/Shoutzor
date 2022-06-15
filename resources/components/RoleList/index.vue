<template>
    <base-table>
        <template #header>
            <th class="w-1 tableHeaderCheckbox"></th>
            <th>Role</th>
            <th>Description</th>
            <th>Actions</th>
        </template>
        <template v-slot>
            <template v-if="roles.length > 0">
                <role-item
                    v-for="(role, index) in roles"
                    :key="role.id"
                    :role="role"
                ></role-item>
            </template>
            <template v-else>
                <tr>
                    <td colspan="4">No roles found</td>
                </tr>
            </template>
        </template>
    </base-table>
</template>

<script>
import BaseTable from "@components/BaseTable";
import RoleItem from "@components/RoleItem";

export default {
    name: 'role-list',
    components: {BaseTable, RoleItem},
    props: {
        roles: {
            type: Array,
            required: true
        }
    }
}
</script>
