<template>
    <div class="list list-row">
        <PermissionListItem
            v-for="(permission, index) in permissions"
            :key="permission.id"
        ></PermissionListItem>
    </div>
</template>

<script>
    import PermissionListItem from "./PermissionListItem";
    export default {
        components: {PermissionListItem},
        props: ['permissions']
    }
</script>
