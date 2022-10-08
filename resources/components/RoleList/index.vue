<template>
    <div class="roles">
        <template v-if="roles.length === 0">{{ emptyMessage }}</template>
        <template v-else>
            <span v-for="(role, index) in roles"
                  :key="role.id"
            >
                <template v-if="index != 0">, </template>
                {{ role.name }}
            </span>
        </template>
    </div>
</template>

<script>
export default {
    name: 'role-list',
    props: {
        roles: {
            type: Array,
            default: [],
            required: true
        },
        emptyMessage: {
            type: String,
            default: '',
            required: false
        }
    }
}
</script>
