<template>
    <div class="wrapper">
        <div class="container container-tight py-6">
            <div class="text-center mb-4">
                <img class="logo" alt="Shoutz0r logo" src="@static/images/shoutzor-logo-header.png">
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="mb-3 text-center">Login to your account</h2>

                    <div v-if="isAuthenticated">
                        <div v-if="isLoading" class="text-center">
                            <p>Loading user information</p>
                            <div class="spinner-border" role="status"></div>
                        </div>
                        <div v-else class="text-center">
                            <base-alert type="danger" class="mb-2">You are not authorized to access the website
                            </base-alert>
                            <base-button class="mt-2" @click="$emit('logout')">Logout</base-button>
                        </div>
                    </div>

                    <login-form v-else></login-form>
                </div>
            </div>

            <div v-if="isAuthenticated === false" class="text-center text-muted">
                No account yet? <a href="#" tabindex="-1">Sign up</a>
            </div>
        </div>
    </div>
</template>

<script>
import "./LoginScreen.scss";

import BaseAlert from "@components/BaseAlert";
import BaseButton from "@components/BaseButton";
import LoginForm from "@components/LoginForm";

export default {
    name: 'login-screen',

    components: {
        BaseButton,
        BaseAlert,
        LoginForm
    },

    props: {
        isAuthenticated: {
            type: Boolean,
            required: false
        },
        isLoading: {
            type: Boolean,
            required: false
        }
    }
}
</script>
