import axios from 'axios';
import {reactive} from "vue";
import {useMutation} from "@vue/apollo-composable";

import {LOGIN_MUTATION, LOGOUT_MUTATION, WHOAMI_MUTATION} from "@graphql/auth";

class AuthenticationManager {
    #app

    #echoClient
    #httpClient

    #tokenName;
    #token;
    #state;

    constructor(app, tokenName, echoClient, httpClient) {
        this.#app = app;
        this.#tokenName = tokenName;
        this.#token = null;

        this.#state = reactive({
            user: null,
            isAuthenticated: false
        });

        this.#echoClient = echoClient;
        this.#httpClient = httpClient;

        this.#initialize();
    }

    #initialize() {
        let token = localStorage.getItem(this.#tokenName);

        if(!!token) {
            this.#updateToken(token);
        }
    }

    get isAuthenticated() {
        return this.#state.isAuthenticated;
    }

    // Private setter
    #updateIsAuthenticated(value) {
        this.#state.isAuthenticated = value;
    }

    can(_permission) {
        //TODO implement role-based permissions
        return true;
    }

    get token() {
        return this.#token;
    }

    #showError(message) {
        this.#app.config.globalProperties.bootstrapControl.showToast("danger", message);
    }

    #showSuccess(message) {
        this.#app.config.globalProperties.bootstrapControl.showToast("success", message);
    }

    // Private setter
    #updateToken(token) {
        this.#token = token;
        localStorage.setItem(this.#tokenName, token);

        axios.defaults.headers.common.Authorization = 'Bearer ' + token;
        this.#echoClient.connector.options.auth.headers.Authorization = "Bearer " + token;
        this.#httpClient.options.headers.Authorization = "Bearer " + token;
    }

    #removeToken() {
        this.#token = null;
        localStorage.removeItem(this.#tokenName);

        delete axios.defaults.headers.common.Authorization;
        delete this.#echoClient.connector.options.auth.headers.authorization;
        delete this.#httpClient.options.headers.authorization;
    }

    get user() {
        return this.#state.user;
    }

    // Private setter
    #updateUser(user) {
        this.#state.user = user;
    }

    // This function will attempt to load the user object who is the owner of the token
    #getUser() {
        return new Promise((resolve, reject) => {
            const { mutate: whoamiMutate } = useMutation(WHOAMI_MUTATION, {
                fetchPolicy: 'no-cache'
            });

            whoamiMutate()
                .then(result => {
                    this.#updateUser(result.data.whoami.user);
                    this.#updateIsAuthenticated(true);
                    resolve(true);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }

    resumeSession() {
        return new Promise((resolve, reject) => {
            if(!!!this.#token) {
                return reject("No token configured");
            }

            this.#getUser()
                .then(() => {
                    resolve(true);
                })
                .catch(error => {
                    localStorage.removeItem(this.#tokenName);

                    console.error("Failed to login using saved token, reason", error);
                    this.#showError("Failed to automatically login, please try manually");

                    reject(error);
                });
        });
    }

    login(username, password) {
        return new Promise((resolve, reject) => {
            const { mutate: loginMutate } = useMutation(LOGIN_MUTATION, {
                fetchPolicy: 'no-cache'
            });

            // Fetch the token using username / password authentication
            loginMutate({
                input: {
                    username,
                    password,
                },
            }).then(result => {
                this.#updateToken(result.data.login.token);

                this.#getUser()
                    .then(() => {
                        resolve(true);
                    })
                    .catch(error => {
                        console.error("Failed to get user information, reason", error);
                        this.#showError("Failed to get user information, please try again");

                        reject(error);
                    });
            })
            .catch(error => {
                reject(error);
            });
        });
    }

    logout() {
        return new Promise((resolve, reject) => {
            const { mutate: logoutMutate } = useMutation(LOGOUT_MUTATION, {
                fetchPolicy: 'no-cache'
            });

            logoutMutate()
                .then(() => {
                    this.#updateIsAuthenticated(false);
                    this.#removeToken();
                    this.#updateUser(null);
                    this.#showSuccess("You are now signed out");
                    resolve(true);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }
}

export const AuthenticationPlugin = {
    install: (app, options) => {
        app.config.globalProperties.auth = new AuthenticationManager(app, options.tokenName, options.echoClient, options.httpClient);
    }
}
