import {ref, reactive} from "vue";
import {provideApolloClient, useMutation} from "@vue/apollo-composable";

import { LOGIN_MUTATION, WHOAMI_MUTATION, LOGOUT_MUTATION } from "@graphql/auth";

class AuthenticationManager {

    #echoClient
    #httpClient

    #tokenName;
    #token;
    #user;
    #isAuthenticated;

    constructor(tokenName, echoClient, httpClient) {
        this.#tokenName = tokenName;
        this.#token = localStorage.getItem(tokenName);
        this.#user = reactive({});
        this.#isAuthenticated = ref(false);

        this.#echoClient = echoClient;
        this.#httpClient = httpClient;
    }

    get isAuthenticated() {
        return this.#isAuthenticated;
    }

    // we dont use a setter because isAuthenticated shouldn't be changed from outside this class
    #updateIsAuthenticated(value) {
        this.#isAuthenticated.value = value;
    }

    get token() {
        return this.#token;
    }

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
        return this.#user;
    }

    #updateUser(newObj) {
        Object.assign(this.#user, newObj);
    }

    // This function will attempt to load the user object who is the owner of the token
    #getUser() {
        return new Promise((resolve, reject) => {
            const { mutate: whoamiMutate } = useMutation(WHOAMI_MUTATION, {
                fetchPolicy: 'no-cache'
            });

            const { result, onError, onDone} = whoamiMutate()
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
            if(!!this.#token) {
                reject("No token configured");
            }

            this.#getUser()
                .then(() => {
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
            const { result, onError, onDone} = loginMutate({
                input: {
                    username,
                    password,
                },
            }).then(result => {
                console.log(result);
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

            const { result, onError, onDone} = logoutMutate()
                .then(result => {
                    this.#updateIsAuthenticated(false);
                    this.#removeToken();
                    this.#updateUser({});
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

        const AuthManager = new AuthenticationManager(options.tokenName, options.echoClient, options.httpClient);
        app.config.globalProperties.auth = AuthManager;
        app.provide('auth', AuthManager);
    }
}
