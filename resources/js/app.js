import axios from 'axios';
import Echo from 'laravel-echo';
import router from "@js/router";
import mitt from 'mitt';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import { createApp } from 'vue'
import {BootstrapIconsPlugin} from 'bootstrap-icons-vue';
import {DefaultApolloClient, provideApolloClient} from '@vue/apollo-composable'
import {ApolloClient, ApolloLink, HttpLink } from '@apollo/client/core'
import {createLighthouseSubscriptionLink} from "@thekonz/apollo-lighthouse-subscription-link";
import App from "@js/views/App.vue";
import { cache } from "@graphql/cache";
import { AuthenticationPlugin } from "@js/plugins/Authentication";
import { RequestManagerPlugin } from "@js/plugins/RequestManager";
import { MediaPlayerPlugin } from "@js/plugins/MediaPlayer";
import { BootstrapControlPlugin } from "@js/plugins/BootstrapControl";
import {UploadManagerPlugin} from "@js/plugins/UploadManager";

// The UploadManager still uses Axios. Ideally this also should be replaced by GraphQL later on
// Currently not the case because I haven't figured out how to track upload progress.
axios.defaults.baseURL = window.Laravel.APP_URL + '/api';
axios.defaults.headers.common['Accept'] = 'application/json';

const emitter = mitt();
window.Pusher = require('pusher-js');

let echoClient = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_SOCKET_HOST,
    wsPort: process.env.MIX_PUSHER_PORT,
    wssPort: process.env.MIX_PUSHER_PORT,
    forceTLS: process.env.MIX_PUSHER_SCHEME === 'https',
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/graphql/subscriptions/auth'
});

// HTTP connection to the API
const httpLink = new HttpLink({
    // You should use an absolute URL here
    uri: window.Laravel.APP_URL + '/graphql',
    headers: {}
});

// Create the apollo client
const apolloClient = new ApolloClient({
    link: ApolloLink.from([
        createLighthouseSubscriptionLink(echoClient),
        httpLink
    ]),
    cache,
    connectToDevTools: window.Laravel.APP_DEBUG,
    defaultOptions: {
        $query: {
            fetchPolicy: 'cache-and-network',
        },
    }
});

// Create the Vue App instance
const app = createApp(App);

app.config.globalProperties.$filters = {
    formatTime(seconds) {
        let sec_num = parseInt(seconds, 10); // don't forget the second param
        let h = Math.floor(sec_num / 3600);
        let m = Math.floor((sec_num - (h * 3600)) / 60);
        let s = sec_num - (h * 3600) - (m * 60);

        //If hours eq 0, hide it
        if (h === 0) {
            h = "";
        } else {
            if (h < 10) {
                h = "0" + h + ":";
            } else {
                h = h + ":";
            }
        }

        if (m < 10) {
            m = "0" + m;
        }
        if (s < 10) {
            s = "0" + s;
        }
        return h + m + ':' + s;
    }
};

app.provide(DefaultApolloClient, apolloClient);
provideApolloClient(apolloClient);

app.config.globalProperties.echo = echoClient;
app.config.globalProperties.emitter = emitter;

app.use(router)
    .use(BootstrapControlPlugin)
    .use(AuthenticationPlugin, {
        tokenName: 'token',
        echoClient,
        httpClient: httpLink
    })
    .use(MediaPlayerPlugin, {
        broadcastUrl: window.Laravel.BROADCAST_URL,
        apolloClient,
        echoClient
    })
    .use(UploadManagerPlugin, {
        echoClient
    })
    .use(RequestManagerPlugin)
    .use(PerfectScrollbar)
    .use(BootstrapIconsPlugin)
    .mount('#shoutzor');
