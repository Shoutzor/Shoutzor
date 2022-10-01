import axios from 'axios';
import {reactive} from "vue";
import {useMutation, useQuery} from "@vue/apollo-composable";

import {LOGIN_MUTATION, LOGOUT_MUTATION, WHOAMI_MUTATION} from "@graphql/auth";
import {GUEST_PERMISSIONS_QUERY} from "../../graphql/auth";

class AuthenticationManager {
    #app

    #echoClient
    #httpClient
    #apolloClient

    #tokenName;
    #token;
    #guestPermissions;
    #state;

    constructor(app, tokenName, echoClient, httpClient, apolloClient) {
        this.#echoClient = echoClient;
        this.#httpClient = httpClient;
        this.#apolloClient = apolloClient;

        this.#app = app;
        this.#tokenName = tokenName;
        this.#token = null;
        this.#guestPermissions = [];

        this.#state = reactive({
            isInitialized: false,
            user: null,
            permissions: []
        });

        this.#initialize();
    }

    /*
        Getters
     */

    get isInitialized() {
        return this.#state.isInitialized;
    }

    get isAuthenticated() {
        return this.#state.user !== null;
    }

    get token() {
        return this.#token;
    }

    get user() {
        return this.#state.user;
    }

    /*
        Setters
     */

    #setUser(user) {
        this.#state.user = user;
    }

    // Sets the new permissions that the user has; the can() method uses these to determine its output
    #setPermissions(permissions) {
        this.#state.permissions = permissions;
    }

    // Sets the token to be used by the frontend
    #setToken(token) {
        this.#token = token;
        localStorage.setItem(this.#tokenName, token);

        axios.defaults.headers.common.Authorization = 'Bearer ' + token;
        this.#echoClient.connector.options.auth.headers.Authorization = "Bearer " + token;
        this.#httpClient.options.headers.Authorization = "Bearer " + token;
    }

    // Removes the token to be used by the frontend
    #removeToken() {
        this.#token = null;
        localStorage.removeItem(this.#tokenName);

        delete axios.defaults.headers.common.Authorization;
        delete this.#echoClient.connector.options.auth.headers.authorization;
        delete this.#httpClient.options.headers.authorization;
    }

    async #initialize() {
        let token = localStorage.getItem(this.#tokenName);
        let sessionPromise = null;
        let guestPermissionsPromise = await this.#updateGuestPermissions();

        if(!!token) {
            this.#setToken(token);
            sessionPromise = this.#resumeSession();
            sessionPromise.catch(() => {
                // If resumeSession failed, this will ensure the guest permissions are set correctly
                this.#invalidateSession();
            })
        }
        else {
            this.#invalidateSession();
        }

        // Once all promises are resolved, the AuthenticationManager has finished initializing
        Promise.allSettled([guestPermissionsPromise, sessionPromise])
            .finally(() => {
                this.#state.isInitialized = true;
            });
    }

    #resumeSession() {
        return new Promise((resolve, reject) => {
            if(!!!this.#token) {
                return reject("No token configured");
            }

            this.#updateUser()
                .then(() => {
                    resolve(true);
                })
                .catch(error => {
                    console.error("Failed to login using saved token, reason", error);
                    this.#showError("Failed to automatically login, please try manually");
                    reject(error);
                });
        });
    }

    #updateGuestPermissions() {
        return new Promise((resolve, reject) => {
            this.#apolloClient.query({
                query: GUEST_PERMISSIONS_QUERY
            })
            .then((result) => {
                let permissions = result.data?.role?.permissions;
                this.#guestPermissions = (permissions === null) ? [] : permissions.map(p => p.name);
                resolve();
            })
            .catch((error) => {
                this.#guestPermissions = [];
                reject("Failed updating the guest permissions");
            });
        });
    }

    // This function will attempt to load the user object who is the owner of the token
    #updateUser() {
        return new Promise((resolve, reject) => {
            const { mutate: whoamiMutate } = useMutation(WHOAMI_MUTATION, {
                fetchPolicy: 'no-cache'
            });

            whoamiMutate()
                .then(result => {
                    this.#setUser(result.data.whoami.user);
                    this.#setPermissions(result.data.whoami.user.allPermissions.map(p => p.name));
                    resolve(true);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }

    #invalidateSession() {
        this.#setUser(null);
        this.#setPermissions(this.#guestPermissions);
        this.#removeToken();
    }

    #showError(message) {
        this.#app.config.globalProperties.bootstrapControl.showToast("danger", message);
    }

    #showSuccess(message) {
        this.#app.config.globalProperties.bootstrapControl.showToast("success", message);
    }

    can(permission) {
        return this.#state.permissions.includes(permission);
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
                this.#setToken(result.data.login.token);
                this.#updateUser()
                    .then(() => {
                        resolve(true);
                    })
                    .catch(error => {
                        console.error("Failed to get user information, reason", error);
                        this.#showError("Failed to get user information, please try again");
                        reject(error);
                    });
            }).catch(error => {
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
                    this.#invalidateSession();
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
        app.config.globalProperties.auth = new AuthenticationManager(app, options.tokenName, options.echoClient, options.httpClient, options.apolloClient);
    }
}
