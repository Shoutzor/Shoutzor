<template>
    <div class="login-form">
        <base-alert v-if="error" :type="error.type">{{ error.message }}</base-alert>

        <form class="auth-login-form mb-0" @submit.prevent="onLogin">
            <base-input :hasError="fieldError.includes('username')" v-model="username" name="username" placeholder="Username" autocomplete="username" />
            <base-input :hasError="fieldError.includes('password')" v-model="password" name="password" placeholder="Password" autocomplete="current-password" class="mt-1" />

            <label class="form-check mt-1" data-children-count="1">
                <input v-model="remember_me" class="form-check-input" type="checkbox" />
                <span class="form-check-label">Remember me</span>
            </label>

            <base-button :disabled="loading" type="submit" class="btn-primary mt-2">
                <template v-if="loading"><base-spinner /></template>
                <template v-else>Login</template>
            </base-button>

            <base-button :disabled="loading" class="btn btn-secondary mt-2 ms-1" type="button">Register</base-button>
        </form>
    </div>
</template>

<script>
import "./LoginForm.scss";

import { ref, reactive } from "vue";

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

    props: {
        remember_me: {
            type: Boolean,
            required: false,
            default: false
        },
        loading: {
            type: Boolean,
            required: false,
            default: false
        },
        error: {
            type: Object,
            required: false,
            default: null
        },
        fieldError: {
            type: Array,
            required: false,
            default: []
        }
    },

    emits: ['login'],

    setup(props, { emit }) {
        const username = ref("test");
        const password = ref("b");
        props = reactive(props);

        return {
            username,
            password,
            onLogin() {
                emit('login', {
                    username: this.username,
                    password: this.password,
                    remember_me: this.remember_me
                });
            }
        }
    }
}
</script>
