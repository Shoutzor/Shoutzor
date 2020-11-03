<template>
    <shoutzor v-if="can('website.access')"></shoutzor>
    <login-screen v-else></login-screen>
</template>

<script>
import {mapGetters} from 'vuex';
import Shoutzor from "@js/views/Shoutzor";
import LoginScreen from "@js/components/login/LoginScreen";

export default {
    name: "App",
    components: {
        LoginScreen,
        Shoutzor
    },
    computed: mapGetters({
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
