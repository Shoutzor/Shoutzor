<template>
    <div class="dropdown-menu dropdown-menu-right auth-dropdown">
        <div v-if="errors.includes('invalid')" class="alert alert-danger mb-1" role="alert">
            {{ error_message }}
        </div>

        <form id="auth-login-form" class="mb-0" @submit.prevent="handleLogin">
            <input v-bind:class="[errors.includes('username') ? 'is-invalid' : '', 'form-control']" type="text" v-model="username" name="username" placeholder="Username" />
            <input v-bind:class="[errors.includes('password') ? 'is-invalid' : '', 'form-control', 'mt-1']"  type="password" v-model="password" name="password" placeholder="Password" />
            <label class="form-check mt-1" data-children-count="1">
                <input v-model="remember_me" class="form-check-input" type="checkbox" />
                <span class="form-check-label">Remember me</span>
            </label>
            <button type="submit" class="btn btn-primary mt-2">Login</button>
        </form>

        <div class="dropdown-divider"></div>

        <button type="button" class="btn btn-secondary">Register</button>
    </div>
</template>


<script>
export default {
    name: 'headerTop',
    data() {
        return {
            username: null,
            password: null,
            remember_me: false,
            errors: [],
            error_message: ""
        }
    },
    created() {
    },
    beforeDestroy() {
        this.errors = [];
        this.username = null;
        this.password = null;
    },
    methods: {
        handleLogin: function(e) {
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

            this.$login(this.username, this.password, this.remember_me).then(function(result){
                // Login success, Clear the form
                this.username = null;
                this.password = null;
            }).catch(function(error){
                // Display error message
                this.errors.push("invalid");
                this.error_message = result.message;
            });
        }
    }
}
</script>

<style lang="scss">
    .auth-dropdown {
        padding: 5px;

        button {
            width: 100%;
        }

        .form-control.is-invalid {
            border-color: red !important;
        }
    }
</style>
