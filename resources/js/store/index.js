import Vue from 'vue'
import Vuex from 'vuex'
import media from './modules/media'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        media
    },
    strict: debug
})
