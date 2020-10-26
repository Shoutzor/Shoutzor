import axios from 'axios'
import Vue from 'vue';
import Vuex from 'vuex';
import VuexORM from '@vuex-orm/core'
import VuexORMAxios from '@vuex-orm/plugin-axios'
import database from '@js/database'
import Authentication from "@js/modules/Authentication";

Vue.use(Vuex);

VuexORM.use(VuexORMAxios, {
    axios
});

const debug = process.env.NODE_ENV !== 'production'

const store = new Vuex.Store({
    strict: debug,
    plugins: [VuexORM.install(database)],
    modules: [{
        'Authentication': Authentication
    }]
});

export default store;
