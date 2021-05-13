<template>
    <div id="wrapper">
        <div id="container" class="container-tight py-6">
            <div class="text-center mb-4">
                <img id="logo" alt="Shoutz0r logo" src="@static/images/shoutzor-logo-header.png">
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="mb-3 text-center">Login to your account</h2>

                    <div v-if="hasToken">
                        <div v-if="can('website.access')" class="text-center">
                            <p>Loading user information</p>
                            <div class="spinner-border" role="status"></div>
                        </div>
                        <div v-else class="text-center">
                            <div class="alert alert-danger mb-2" role="alert">You are not authorized to access the website</div>
                            <button
                                class="btn btn-primary mt-2"
                                v-on:click="logout">Logout
                            </button>
                        </div>
                    </div>
                    <login-form v-else></login-form>
                </div>
            </div>
            <div v-if="hasToken === false" class="text-center text-muted">
                Don't have account yet? <a href="#" tabindex="-1">Sign up</a>
            </div>
        </div>
    </div>
</template>

<script>
import LoginForm from "@js/components/login/LoginForm";
import {mapGetters} from "vuex";

export default {
    name: 'LoginScreen',
    components: {LoginForm},
    computed: mapGetters({
        can: 'can',
        hasToken: 'hasToken'
    }),
    methods: {
        logout: function() {
            this.$store.dispatch('logout');
        }
    }
}
</script>

<style lang="scss" scoped>
#wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

#container {
    flex: none;
    height: initial;
}

#logo {
    filter: brightness(0) invert(1);
}
</style>
