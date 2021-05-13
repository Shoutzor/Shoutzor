import axios from 'axios'
import Vue from 'vue';
import Vuex from 'vuex';
import VuexORM from '@vuex-orm/core'
import VuexORMAxios from '@vuex-orm/plugin-axios'
import database from '@js/database'
import Player from '@js/store/modules/MediaPlayer/Player';
import moduleAuthentication from "@js/store/modules/Authentication";
import moduleMediaPlayer from "@js/store/modules/MediaPlayer";

Vue.use(Vuex);

Vue.prototype.$http = axios;
axios.defaults.headers.common['Accept'] = 'application/json';
axios.interceptors.response.use(undefined, function(err) {
    return new Promise(function(resolve, reject) {
        if(err.status === 401 && err.config && !err.config.__isRetryRequest) {
            this.$store.dispatch('logout');
        }
        throw err;
    });
});

Vue.prototype.$player = Player;

VuexORM.use(VuexORMAxios, {
    axios
});

const debug = process.env.NODE_ENV !== 'production'

const store = new Vuex.Store({
    strict: debug, plugins: [VuexORM.install(database)], modules: {
        'Authentication': moduleAuthentication, 'MediaPlayer': moduleMediaPlayer
    }
});

export default store;
