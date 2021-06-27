import Vue from "vue";
import VueBus from 'vue-bus';
import router from "./router/app-installer";
import App from "@js/views/App";
import VueTablerIcons from 'vue-tabler-icons';

//Recursively scan and add all Vue components
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Create our Vue instance
const app = new Vue({
    components: {App},
    router
});

Vue.use(VueTablerIcons);
Vue.use(VueBus);

app.$mount('#installer');

//Load other components
require('./bootstrap');
