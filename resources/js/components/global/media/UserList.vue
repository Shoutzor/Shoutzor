<template>
    <div v-if="users !== null" class="users">
        <span v-for="(user, index) in users"
              :key="user.id"
        >
            <template v-if="index != 0">, </template>
            {{ user.username }}
        </span>
    </div>
</template>

<script>
export default {
    props: ['users']
}
</script>