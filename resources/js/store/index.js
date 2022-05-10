import { createStore } from 'vuex';
import VuexORM from '@vuex-orm/core'
import database from '@js/database'
import moduleAuthentication from "@js/store/modules/Authentication";
import moduleMediaPlayer from "@js/store/modules/MediaPlayer";

const debug = process.env.NODE_ENV !== 'production'

export default createStore({
    strict: debug,
    plugins: [VuexORM.install(database)],
    modules: {
        'Authentication': moduleAuthentication,
        'MediaPlayer': moduleMediaPlayer
    }
});