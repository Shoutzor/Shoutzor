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

import gql from "graphql-tag";
import {ref, reactive} from "vue";
import {useMutation} from "@vue/apollo-composable";

import BaseAlert from "@components/BaseAlert";
import BaseButton from "@components/BaseButton";
import BaseInput from "@components/BaseInput";
import BaseSpinner from "@components/BaseSpinner";
import {isLoggedInVar} from "@graphql/cache";
import { LOGIN_MUTATION } from "@graphql/auth";

export default {
    name: 'login-form',

    components: {
        BaseSpinner,
        BaseButton,
        BaseInput,
        BaseAlert
    },

    setup(props, {emit}) {
        const username = ref("");
        const password = ref("");
        props = reactive(props);

        const {mutate: login, loading, error, onDone} = useMutation(LOGIN_MUTATION, () => ({
            fetchPolicy: 'no-cache',
            variables: {
                input: {
                    username: username.value,
                    password: password.value,
                },
            }
        }));

        onDone(result => {
            localStorage.setItem('token', result.data.login.token);
            isLoggedInVar.value = true;
        });

        return {
            loading,
            error,
            username,
            password,
            login
        }
    }
}
</script>
