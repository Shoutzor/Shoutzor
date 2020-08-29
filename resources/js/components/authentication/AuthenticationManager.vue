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

        //Append the API-Token to each API-call (if authenticated)
        axios.interceptors.request.use((request) => {
            let cookie = this.getApiToken();

            if(cookie !== null){
                request.headers = {
                    Authorization: 'Bearer ' + cookie,
                    Accept: 'application/json'
                }
            }

            return request;
        }, function(error) {
            return Promise.reject(error);
        });
    },

    mounted() {
        this.checkAuthentication();
    },

    beforeDestroy() {
        this.$bus.off('auth-login', this.login);
        this.$bus.off('auth-logout', this.logout);
    },

    methods: {
        getApiToken() {
            return (document.cookie.match(/^(?:.*;)?\s*token\s*=\s*([^;]+)(?:.*)?$/)||[,null])[1];
        },

        checkAuthentication() {
            this.api_token = this.getApiToken();

            //If the cookie exists, get the user information
            if(this.api_token !== null) {
                this.getUser((result) => {
                    this.isAuthenticated = (result.success === true);
                });
            }
        },

        getUser(callback) {
            axios.get('/api/auth/user', {
            }).then(res => {
                this.user = res.data;

                callback({
                    success: true
                });
            }).catch(err => {
                switch(err.response.status) {
                    case 401:
                        this.deleteSessionData();
                        break;

                    default:
                        //Any other errors are probably server errors.
                }

                callback({
                    success: false
                });
            });
        },

        setAuthorizationCookie(data) {
            /*
            Disabling this for now. Ideally a environment variable is set to allow the webmaster to enforce HTTPS
            Locally hosted LAN-environments won't be able to properly support HTTPS, which would, despite being
            very insecure, break the authentication system from shoutz0r entirely.

            if('https:' !== document.location.protocol) {
                console.error("Shoutz0r could not create the access_token cookie since HTTPS is required for this.");
            }
            */

            let d = new Date(data.expires_at);
            let expires = "expires=" + d.toUTCString();
            document.cookie = "token=" + data.access_token + ";" + expires + ";path=/;SameSite=Lax";
        },

        removeAuthorizationCookie() {
            this.setAuthorizationCookie({
                expires_at: 0,
                access_token: ''
            });
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
            //TODO call logout route on the server to invalidate the access_token
            this.deleteSessionData();
        },

        deleteSessionData() {
            this.user = null;
            this.api_token = null;
            this.removeAuthorizationCookie();
            this.isAuthenticated = false;
        }
    }
}
</script>
