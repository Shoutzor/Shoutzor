import { createApp, configureCompat } from 'vue';
import { Dropdown } from 'bootstrap';
import mitt from 'mitt';
import FastAverageColor from "fast-average-color";
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import Echo from  'laravel-echo';
import { BootstrapIconsPlugin  } from 'bootstrap-icons-vue';
import http from './http';
import router from "./router/app";
import store from "./store";
import Player from "@js/store/modules/MediaPlayer/Player";
import App from "@js/views/App.vue";
import ShoutzorPlugin from "@js/plugins/Shoutzor/plugin";

// use @vue/compat new render API
configureCompat({ RENDER_FUNCTION: false });

const emitter = mitt();

window.io = require('socket.io-client');

// Create the laravel Echo connection instance
const echoInstance = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    namespace: 'App.Events',
    forceTLS: true
});

// Create the Vue App instance
const app = createApp(App);

app.config.globalProperties.emitter = emitter;
app.config.globalProperties.echo = echoInstance;
app.config.globalProperties.player = Player;
app.config.globalProperties.fac = new FastAverageColor();

store.$emitter = emitter;

app.use(http)
   .use(router)
   .use(store)
   .use(ShoutzorPlugin)
   .use(PerfectScrollbar)
   .use(BootstrapIconsPlugin)
   .mount('#shoutzor');
