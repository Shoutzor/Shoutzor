import axios from 'axios';
import User from "@js/models/User";
import { AUTH_REQUEST, AUTH_SUCCESS, AUTH_FAILED, AUTH_LOGOUT } from "@js/store/mutation-types";

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
        getUser: state => state.user
        /*    isAuthenticated: state => {
                console.log(state.token);
                return !!state.token
            },
            authStatus: state => {
                console.log(state.status)
                return state.status
            },
            getUser: state => {
                console.log(state.user);
                return state.user
            }*/
    },

    actions: {
        login({commit, dispatch}, login) {
            return new Promise((resolve, reject) => { // The Promise used for router redirect in login
                commit(AUTH_REQUEST);

                // Set our request config
                let config = {
                    dataKey: 'user'
                };

                // Make the request
                User.api().post('/api/auth/login', login, config)
                    .then((resp) => {
                        const token = resp.response.data.token;
                        const user = resp.entities.users[0];

                        console.log(resp, user);

                        localStorage.setItem('token', token);
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                        commit(AUTH_SUCCESS, {
                            token,
                            user
                        });

                        resolve(resp);
                    })
                    .catch((err) => {
                        commit(AUTH_FAILED, err.message);
                        localStorage.removeItem('token'); // if the request fails, remove any possible user token if possible
                        reject(err.message);
                    });
            });
        },

        logout({commit}){
            return new Promise((resolve, reject) => {
                commit(AUTH_LOGOUT);
                localStorage.removeItem('token');
                delete axios.defaults.headers.common['Authorization'];
                resolve();
            });
        }
    }
}

export default moduleAuthentication;
