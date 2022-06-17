<template>
    <div v-if="loading" class="d-flex flex-grow-1 align-items-center justify-content-center">
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
    data() {
        return {
            loading: true,
            hasAccess: true
        };
    },
    created() {
        this.auth.resumeSession()
            .finally(() => {
                this.loading = false;
            });
    }
}
</script>
