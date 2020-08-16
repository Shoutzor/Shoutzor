<template></template>

<script>

export default {
    data(){
        return {
            isAuthenticated: false,
            user: null
        }
    },

    watch: {
        isAuthenticated: function() {
            this.$bus.emit('auth-status', {
                isAuthenticated: this.isAuthenticated,
                user: this.user
            });
        }
    },

    mounted() {
        this.$bus.on('auth-login', this.login);
        this.$bus.on('auth-logout', this.logout);
    },

    beforeDestroy() {
        this.$bus.off('auth-login', this.login);
        this.$bus.off('auth-logout', this.logout);
    },

    methods: {
        login() {

        },

        logout() {

        }
    }
}
</script>
