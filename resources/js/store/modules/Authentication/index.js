import axios from 'axios';
import User from "@js/models/User";
import Role from "@js/models/Role";
import { AUTH_GUEST, AUTH_REQUEST, AUTH_SUCCESS, AUTH_FAILED, AUTH_LOGOUT } from "@js/store/mutation-types";
import store from "@js/store/index";
import Vue from "vue";

const moduleAuthentication = {
    state: () => ({
        token: localStorage.getItem('token') || '',
        status: '',
        user: null,
        authenticated: false,
        guestRole: null
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

            // Emit an auth.state event to indicate our authenticated-state has changed
            Vue.bus.emit('auth.state', { authenticated: state.authenticated, user: state.user });
        },
        [AUTH_FAILED](state) {
            state.token = '';
            state.status = 'error';
            state.authenticated = false;

            // Emit event
            Vue.bus.emit('auth.fail');
        },
        [AUTH_LOGOUT](state) {
            state.status = '';
            state.token = '';
            state.user = null;
            state.authenticated = false;

            // Emit an auth.state event to indicate our authenticated-state has changed
            Vue.bus.emit('auth.state', { authenticated: state.authenticated, user: state.user });
        },
        [AUTH_GUEST](state, { guestRole }) {
            state.guestRole = guestRole;
        }
    },

    getters: {
        isAuthenticated: state => state.authenticated,
        authStatus: state => state.status,
        getUser: state => state.user,
        hasToken: state => !!state.token,
        can: state => (permissionName) => {
            // Check if the user is authenticated, and if so, if he has the required permission
            if(state.authenticated) {
                return state.user.can(permissionName);
            }

            // Check if the guest-role exists, and if so, check if it has the required permission
            if(state.guestRole) {
                return state.guestRole.can(permissionName);
            }

            // No matching situations, return false by default.
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
        },

        updateGuestRole({commit}) {
            return new Promise((resolve, reject) => {
                Role.api().get('/api/role/guest').then((resp) => {
                    const role       = resp.entities.roles[0];
                    const guestModel = Role.query().with('permissions').whereId(role.id).first();

                    commit(AUTH_GUEST, {
                        guestRole: guestModel
                    });
                    resolve(true);
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
        }
    }
}

export default moduleAuthentication;
