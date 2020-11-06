<template>
    <div class="list list-row">
        <PermissionListItem
            v-for="(permission, index) in permissions"
            :key="permission.id"
            :permission="permission"
            :hasPermission="!!hasPermissions[index]"
        ></PermissionListItem>
    </div>
</template>

<script>
    import PermissionListItem from "./PermissionListItem";
    export default {
        components: {PermissionListItem},
        props: ['permissions', 'hasPermissions']
    }
</script>
