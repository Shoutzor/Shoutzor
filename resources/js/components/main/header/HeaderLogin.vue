<template>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark auth-dropdown">
        <login-form />

        <div class="dropdown-divider"></div>

        <button class="btn btn-secondary" type="button">Register</button>
    </div>
</template>

<script>
import LoginForm from "@components/LoginForm";

export default {
    name: 'header-login',
    components: {LoginForm}
}
</script>

<style lang="scss">
.auth-dropdown {
    padding: 5px;

    button {
        width: 100%;
    }
}
</style>
