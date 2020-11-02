<template>
    <shoutzor v-if="can('website.access')"></shoutzor>
    <login-screen v-else></login-screen>
</template>

<script>
import {mapGetters} from 'vuex';
import Shoutzor from "./Shoutzor";
import LoginScreen from "../components/login/LoginScreen";

export default {
    name: "App",
    components: {
        LoginScreen,
        Shoutzor
    },
    computed: mapGetters({
        isAuthenticated: 'isAuthenticated',
        can: 'can'
    })
}
</script>

<style scoped lang="scss">
.simplebar-main {
    width: 100%;
    height: 100%;
}
</style>
