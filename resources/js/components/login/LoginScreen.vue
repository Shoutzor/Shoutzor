<template>
    <div class="container-tight py-6">
        <div class="text-center mb-4">
            <img src="@static/images/shoutzor-logo-header.png" id="logo" alt="Shoutz0r logo">
        </div>
        <form class="card card-md" action="#" @submit.prevent="login" method="post">
            <div class="card-body">
                <h2 class="mb-3 text-center">Login to your account</h2>
                <div v-if="errors.includes('invalid')" class="alert alert-danger mb-3" role="alert">
                    {{ error_message }}
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" v-bind:class="[errors.includes('username') ? 'is-invalid' : '', 'form-control']" v-model="username" name="username" placeholder="Username" autocomplete="off">
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        Password
                        <span class="form-label-description">
                            <a href="#">I forgot my password</a>
                        </span>
                    </label>
                    <div class="input-group input-group-flat">
                        <input type="password" v-bind:class="[errors.includes('password') ? 'is-invalid' : '', 'form-control', 'mt-1']" v-model="password" name="password" placeholder="Password" autocomplete="off">
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" v-model="remember_me">
                        <span class="form-check-label">Remember me on this device</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted">
            Don't have account yet? <a href="#" tabindex="-1">Sign up</a>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoginScreen',
    data() {
        return {
            username: null,
            password: null,
            remember_me: false,
            errors: [],
            error_message: ""
        }
    },
    beforeDestroy() {
        this.errors = [];
        this.username = null;
        this.password = null;
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

            let email = this.email
            let password = this.password

            this.$store.dispatch('login', {
                username: this.username,
                password: this.password,
                remember_me: this.remember_me
            })
            .then(() => {
                // Login success, Clear the form
                this.username = null;
                this.password = null;
            })
            .catch(err => {
                // Display error message
                this.errors.push("invalid");
                console.log(err);
                this.error_message = err;
            });
        }
    }
}
</script>

<style lang="scss" scoped>
    #logo {
        filter: brightness(0) invert(1);
    }
</style>
