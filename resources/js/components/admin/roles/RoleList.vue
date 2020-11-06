<template>
    <table class="table table-vcenter table-mobile-md card-table">
        <thead>
            <th class="w-1 tableHeaderCheckbox"></th>
            <th>Role</th>
            <th>Description</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <RoleListItem
                v-for="(role, index) in roles"
                :key="role.id"
                :role="role"
            ></RoleListItem>
        </tbody>
    </table>
</template>

<script>
    import RoleListItem from "./RoleListItem";
    export default {
        components: {RoleListItem},
        props: ['roles']
    }
</script>

<style lang="scss" scoped>

.tableHeaderCheckbox {

}

</style>
