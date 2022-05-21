<template>
    <div class="list list-row">
        <template v-if="permissions.length > 0">
            <PermissionListItem
                v-for="(permission, index) in permissions"
                :key="permission.id"
                :hasPermission="!!hasPermissions[index]"
                :permission="permission" />
        </template>
    </div>
</template>

<script>
import PermissionItem from "@components/PermissionItem";

export default {
    components: { PermissionItem },
    props: {
        permissions: {
            type: Array,
            required: false
        },
        hasPermissions: {
            type: Array,
            required: false
        }
    }
}
</script>
