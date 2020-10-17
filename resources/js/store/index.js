import axios from 'axios'
import Vue from 'vue';
import Vuex from 'vuex';
import VuexORM from '@vuex-orm/core'
import VuexORMAxios from '@vuex-orm/plugin-axios'
import database from '@js/database'

Vue.use(Vuex);

VuexORM.use(VuexORMAxios, {
    axios
});

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    strict: debug,
    plugins: [VuexORM.install(database)]
})
