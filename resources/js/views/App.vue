<template>
    <div v-if="!hasLoaded" class="d-flex flex-grow-1 align-items-center justify-content-center">
        <load-screen message="Loading, please wait"/>
    </div>

    <shoutzor v-else-if="hasAccess"/>
    <login-screen v-else/>
</template>

<script>
import LoadScreen from "@components/LoadScreen";
import Shoutzor from "@js/views/Shoutzor";
import LoginScreen from "@components/LoginScreen";

export default {
    name: "App",
    components: {
        LoadScreen,
        LoginScreen,
        Shoutzor
    },
    computed: {
        hasLoaded() {
            return this.auth.isInitialized;
        },
        hasAccess() {
            return this.auth.can("website.access");
        }
    }
}
</script>
