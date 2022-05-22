<template>
    <div class="loginform">
        <base-alert v-if="error" :type="error.type">{{ error.message }}</base-alert>

        <form class="auth-login-form" class="mb-0" @submit.prevent="login">
            <base-input :hasError="error.source.includes('username')" v-model="username" name="username" autocomplete="username" />
            <base-input :hasError="error.source.includes('password')" v-model="password" name="password" autocomplete="current-password" class="mt-1" />

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
            required: false
        },
        password: {
            type: String,
            required: false
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
        }
    }
}
</script>
