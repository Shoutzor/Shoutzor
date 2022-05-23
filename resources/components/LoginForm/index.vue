<template>
    <div class="loginform">
        <base-alert v-if="error" :type="error.type">{{ error.message }}</base-alert>

        <form class="auth-login-form mb-0" @submit="onLogin">
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
        </form>
    </div>
</template>

<script>
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
        username: {
            type: String,
            required: false,
            default: ''
        },
        password: {
            type: String,
            required: false,
            default: ''
        },
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

    methods: {
        onLogin() {
            emit('login');
        }
    }
}
</script>
