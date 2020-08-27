<template></template>

<script>
import axios from 'axios';

export default {
    data(){
        return {
            isAuthenticated: false,
            api_token: null,
            user: null
        }
    },

    watch: {
        isAuthenticated: function() {
            this.$bus.emit('auth-status', {
                isAuthenticated: this.isAuthenticated,
                user: this.user
            });
        }
    },

    created() {
        this.$bus.on('auth-login', this.login);
        this.$bus.on('auth-logout', this.logout);
    },

    mounted() {
        this.checkAuthentication();
    },

    beforeDestroy() {
        this.$bus.off('auth-login', this.login);
        this.$bus.off('auth-logout', this.logout);
    },

    methods: {
        checkAuthentication() {
            this.api_token = (document.cookie.match(/^(?:.*;)?\s*token\s*=\s*([^;]+)(?:.*)?$/)||[,null])[1];

            console.log("api token: ", this.api_token);

            //If the cookie exists, get the user information
            if(this.api_token !== null) {
                let user = this.user;
                let isAuthenticated = this.isAuthenticated;

                this.getUser((result) => {
                    user = result.user;

                    if(result.success === true) {
                        isAuthenticated = true;
                    }
                });
            }
        },

        getUser(callback) {
            axios.get('/api/auth/user?api_token=' + this.api_token, {
            }).then(res => {
                console.log("API Success:", res.response, res.response.status);
                callback({
                    success: true,
                    user: res.data
                });
            }).catch(err => {
                console.log("API Error:", err.response, err.response.status);

                //TODO handle errors someway proper. not every error indicates that the user doesn't exist anymore

                callback({
                    success: false,
                    user: null
                });
            });
        },

        setAuthorizationCookie(data) {
            if('https:' !== document.location.protocol) {
                console.error("Shoutz0r could not create the access_token cookie since HTTPS is required for this.");
            }

            let d = new Date(data.expires_at);
            let expires = "expires=" + d.toUTCString();
            document.cookie = "token=" + data.access_token + ";" + expires + ";path=/;secure";
        },

        login(data) {
            //Validate data object
            if(typeof data !== 'object' || data === null) {
                console.log("Invalid login data provided", data);
                return;
            }

            //Check if a callback method is defined
            if(data.callback === undefined || typeof data.callback !== 'function') {
                data.callback = (res) => {};
            }

            //validate username
            if(data.username === undefined || data.username === null || data.username.length === 0) {
                data.callback({
                    success: false,
                    message: "No username provided"
                });
                return;
            }

            //validate password
            if(data.password === undefined || data.password === null || data.password.length === 0) {
                data.callback({
                    success: false,
                    message: "No password provided"
                });
                return;
            }

            //validate remember_me
            if(data.remember_me === undefined || data.remember_me === null) {
                data.remember_me = false;
            }

            //Perform authentication
            axios.post('/api/auth/login', {
                username: data.username,
                password: data.password,
                remember_me: data.remember_me
            }).then(res => {
                console.log("API Success:");
                console.log(res);
                console.log(res.data);

                this.setAuthorizationCookie(res.data);
                this.checkAuthentication();

                data.callback({
                    success: true,
                    message: "Authentication success"
                });
            }).catch(err => {
                console.log("API Error:", err.response, err.response.status);
                let message = "";

                switch(err.response.status) {
                    case 401:
                        message = "Incorrect login";
                        break;

                    default:
                        message = "Unknown error";
                }

                data.callback({
                    success: false,
                    message: message
                });
            });
        },

        logout(callback) {

        }
    }
}
</script>
