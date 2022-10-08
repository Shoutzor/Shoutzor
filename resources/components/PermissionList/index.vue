<template>
    <div class="list list-row">
        <template v-if="permissions.length > 0">
            <permission-item
                v-for="(permission, index) in permissions"
                :key="permission.id"
                :hasPermission="activePermissions.indexOf(permission.name) !== -1"
                :permission="permission"/>
        </template>
    </div>
</template>

<script>
import PermissionItem from "@components/PermissionItem";

export default {
    components: {
        PermissionItem
    },
    props: {
        permissions: {
            type: Array,
            required: true
        },
        hasPermissions: {
            type: Array,
            required: true
        }
    },
    computed: {
        activePermissions() {
            return this.hasPermissions.map(p => p.name);
        }
    }
}
</script>
