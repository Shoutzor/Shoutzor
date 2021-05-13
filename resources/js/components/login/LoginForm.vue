<template>
    <div id="loginform">
        <div v-if="errors.includes('invalid')" class="alert alert-danger mb-2" role="alert">
            {{ error_message }}
        </div>

        <form id="auth-login-form" class="mb-0" @submit.prevent="login">
            <input v-model="username" name="username" placeholder="Username" type="text" v-bind:class="[errors.includes('username') ? 'is-invalid' : '', 'form-control']" />
            <input v-model="password" name="password" placeholder="Password" type="password" v-bind:class="[errors.includes('password') ? 'is-invalid' : '', 'form-control', 'mt-1']" />
            <label class="form-check mt-1" data-children-count="1">
                <input v-model="remember_me" class="form-check-input" type="checkbox" />
                <span class="form-check-label">Remember me</span>
            </label>
            <button v-if="loading === false" class="btn btn-primary mt-2" type="submit">Login</button>
            <button v-if="loading === true" class="btn btn-primary mt-2" type="submit">
                <div class="spinner-border" role="status"></div>
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'LoginForm',
    data() {
        return {
            username: null,
            password: null,
            remember_me: false,
            errors: [],
            error_message: "",
            loading: false
        }
    },
    beforeDestroy() {
        this.errors = [];
        this.username = null;
        this.password = null;
        this.loading = false;
    },
    methods: {
        login: function(e) {
            this.errors = [];

            //Check username
            if(!this.username) {
                this.errors.push("username");
            }

            //Check password
            if(!this.password) {
                this.errors.push("password");
            }

            if(this.errors.length > 0) {
                return;
            }

            let email = this.email;
            let password = this.password;

            this.loading = true;

            this.$store.dispatch('login', {
                    username: this.username,
                    password: this.password,
                    remember_me: this.remember_me
                })
                .then(() => {
                    // Login success, Clear the form
                    this.username = null;
                    this.password = null;
                    this.loading = false;
                })
                .catch(err => {
                    // Display error message
                    this.errors.push("invalid");
                    this.error_message = err;
                    this.loading = false;
                });
        }
    }
}
</script>

<style lang="scss" scoped>
button {
    width: 100%;
}

.form-control.is-invalid {
    border-color: red !important;
}
</style>
