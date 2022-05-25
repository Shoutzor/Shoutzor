<template>
    <load-screen v-if="loading" message="Loading data, please wait" />
    <shoutzor v-else-if="hasAccess" />
    <login-screen v-else />
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
    props: {
        loading: {
            type: Boolean,
            required: false,
            default: false
        },
        hasAccess: {
            type: Boolean,
            required: false,
            default: true
        }
    }
}
</script>
