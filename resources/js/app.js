import { createApp } from 'vue';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import Echo from  'laravel-echo';
import { BootstrapIconsPlugin  } from 'bootstrap-icons-vue';
import router from "./router/app";
import App from "@js/views/App.vue";

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

app.config.globalProperties.echo = echoInstance;

app.use(router)
   .use(store)
   .use(PerfectScrollbar)
   .use(BootstrapIconsPlugin)
   .mount('#shoutzor');
