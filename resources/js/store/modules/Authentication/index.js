import axios from 'axios';
import User from "@js/models/User";
import { AUTH_REQUEST, AUTH_SUCCESS, AUTH_FAILED, AUTH_LOGOUT } from "@js/store/mutation-types";
import store from "@js/store/index";

const moduleAuthentication = {
    state: () => ({
        token: localStorage.getItem('token') || '',
        status: '',
        user: null,
        authenticated: false
    }),

    mutations: {
        [AUTH_REQUEST](state) {
            state.status = 'loading';
        },
        [AUTH_SUCCESS](state, { token, user }) {
            state.status = 'success';
            state.token = token;
            state.user = user;
            state.authenticated = true;
        },
        [AUTH_FAILED](state) {
            state.token = '';
            state.status = 'error';
            state.authenticated = false;
        },
        [AUTH_LOGOUT](state) {
            state.status = '';
            state.token = '';
            state.user = null;
            state.authenticated = false;
        }
    },

    getters: {
        isAuthenticated: state => state.authenticated,
        authStatus: state => state.status,
        getUser: state => state.user,
        hasToken: state => !!state.token,
        can: state => (permissionName) => {
            if(state.authenticated) {
                return state.user.can(permissionName);
            }

            //TODO implement Guest user state
            return false;
        }
    },

    actions: {
        login({commit, dispatch}, login) {
            return new Promise((resolve, reject) => { // The Promise used for router redirect in login
                commit(AUTH_REQUEST);

                // Make the request
                axios.post(
                    '/api/auth/login',
                    login
                ).then((resp) => {
                    const token = resp.data.token;

                    localStorage.setItem('token', token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                    store.dispatch('fetchUserInformation').then((resp) => {
                        commit(AUTH_SUCCESS, {
                            token,
                            user: resp
                        });

                        resolve(true);
                    }).catch((err) => {
                        let msg = "Could not fetch user information, got error:" + err;
                        localStorage.removeItem('token');
                        commit(AUTH_FAILED, msg);
                        reject(msg);
                    });
                }).catch((err) => {
                    let msg = '';

                    try {
                        msg = err.data.message;
                    } catch(e) {
                        //Fallback to default error message
                        msg = err.message;
                    }

                    // if the request fails, remove any possible user token if possible
                    localStorage.removeItem('token');
                    commit(AUTH_FAILED, msg);
                    reject(msg);
                });
            });
        },

        logout({commit}) {
            return new Promise((resolve, reject) => {
                commit(AUTH_LOGOUT);
                localStorage.removeItem('token');
                delete axios.defaults.headers.common['Authorization'];
                resolve();
            });
        },

        fetchUserInformation({commit}) {
            return new Promise((resolve, reject) => {
                // Make the request
                User.api().get('/api/auth/user').then((resp) => {
                    const user = resp.entities.users[0];

                    //Vuex-ORM Axios plugin doesn't yet support (eagerLoading) relations, therefor this is a dirty fix.
                    const userModel = User.query().with(['roles.permissions', 'permissions']).whereId(user.id).first();

                    resolve(userModel);
                }).catch((err) => {
                    let msg = '';

                    try {
                        msg = err.response.data.message;
                    } catch(e) {
                        //Fallback to default error message
                        msg = err.message;
                    }

                    reject(msg);
                });
            });
        },

        resumeSession({commit}) {
            return new Promise((resolve, reject) => { // The Promise used for router redirect in login
                commit(AUTH_REQUEST);

                let token = localStorage.getItem('token');
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                store.dispatch('fetchUserInformation').then((resp) => {
                    commit(AUTH_SUCCESS, {
                        token: token,
                        user: resp
                    });

                    resolve(true);
                }).catch((err) => {
                    let msg = "Could not fetch user information, got error:" + err;
                    localStorage.removeItem('token');
                    commit(AUTH_FAILED, msg);
                    reject(msg);
                });
            });
        }
    }
}

export default moduleAuthentication;
