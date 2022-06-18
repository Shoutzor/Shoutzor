import {reactive} from "vue";
import {provideApolloClient, useMutation} from "@vue/apollo-composable";

import {LOGIN_MUTATION, LOGOUT_MUTATION, WHOAMI_MUTATION} from "@graphql/auth";

class AuthenticationManager {

    #echoClient
    #httpClient

    #tokenName;
    #token;
    #state;

    constructor(tokenName, echoClient, httpClient) {
        this.#tokenName = tokenName;
        this.#token = localStorage.getItem(tokenName);

        this.#state = reactive({
            user: null,
            isAuthenticated: false
        });

        this.#echoClient = echoClient;
        this.#httpClient = httpClient;
    }

    get isAuthenticated() {
        return this.#state.isAuthenticated;
    }

    // Private setter
    #updateIsAuthenticated(value) {
        this.#state.isAuthenticated = value;
    }

    can(permission) {
        //TODO implement role-based permissions
        return true;
    }

    get token() {
        return this.#token;
    }

    // Private setter
    #updateToken(token) {
        this.#token = token;
        localStorage.setItem(this.#tokenName, token);

        this.#echoClient.connector.options.auth.headers.authorization = "Bearer " + token;
        this.#httpClient.options.headers.authorization = "Bearer " + token;
    }

    #removeToken() {
        this.#token = null;
        localStorage.removeItem(this.#tokenName);

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
                    this.#updateIsAuthenticated(true);
                    resolve(true);
                })
                .catch(error => {
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

                this.resumeSession()
                    .then(() => {
                        resolve(true);
                    })
                    .catch(error => {
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

        provideApolloClient(options.apolloClient);

        app.config.globalProperties.auth = new AuthenticationManager(options.tokenName, options.echoClient, options.httpClient);
    }
}
