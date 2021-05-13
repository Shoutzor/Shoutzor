<template>
    <div class="dropdown-menu dropdown-menu-right">
        <router-link
            :to="{name: 'profile'}"
            class="dropdown-item"
        >
            Profile
        </router-link>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item"
           href="#"
           @click.prevent="logout"
        >Logout</a>
    </div>
</template>

<script>
export default {
    name: 'headerUser',
    methods: {
        logout: function() {
            this.$store.dispatch('logout')
                .then(() => {
                    // Do nothing
                });
        }
    }
}
</script>
