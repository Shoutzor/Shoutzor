<template>
    <div class="login-form">
        <base-alert v-if="error" type="danger">{{ error }}</base-alert>

        <form class="auth-login-form mb-0" @submit.prevent="login">
            <base-input v-model="username" name="username" placeholder="Username" autocomplete="username"/>
            <base-input v-model="password" name="password" placeholder="Password" autocomplete="current-password"
                        class="mt-1"/>

            <base-button :disabled="loading" type="submit" class="btn-primary mt-2">
                <template v-if="loading">
                    <base-spinner/>
                </template>
                <template v-else>Login</template>
            </base-button>

            <base-button :disabled="loading" class="btn btn-secondary mt-2 ms-1" type="button">Register</base-button>
        </form>
    </div>
</template>

<script>
import "./LoginForm.scss";

import BaseAlert from "@components/BaseAlert";
import BaseButton from "@components/BaseButton";
import BaseInput from "@components/BaseInput";
import BaseSpinner from "@components/BaseSpinner";

export default {
    name: 'login-form',

    components: {
        BaseSpinner,
        BaseButton,
        BaseInput,
        BaseAlert
    },

    data() {
        return {
            username: '',
            password: '',
            loading: false,
            error: null
        }
    },

    methods: {
        login() {
            this.loading = true;
            this.error = null;

            this.auth.login(this.username, this.password)
                .catch(error => {
                    this.error = error;
                })
                .finally(() => {
                    this.loading = false;
                })
        }
    }
}
</script>
