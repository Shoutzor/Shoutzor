import Vue from "vue";
import VueBus from 'vue-bus';
import router from "./router";
import store from "./store";
import App from "@js/views/App";
import Auth from "@js/mixins/Auth";

import { library } from '@fortawesome/fontawesome-svg-core';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

Vue.use(VueBus);

//Configure the FontAwesome component
library.add(fab);
library.add(fas);

Vue.component('font-awesome-icon', FontAwesomeIcon);

//Recursively scan and add all Vue components
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Create our Vue instance
const app = new Vue({
    components: { App },
    router,
    store
});

Vue.mixin(Auth);
app.$mount('#shoutzor');

//Load other components
require('./bootstrap');
require('./theme');
