import { createApp, provide, h } from 'vue'
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import { BootstrapIconsPlugin  } from 'bootstrap-icons-vue';
import router from "./router/app";
import App from "@js/views/App.vue";
import { DefaultApolloClient } from '@vue/apollo-composable'
import { ApolloClient, createHttpLink, InMemoryCache } from '@apollo/client/core'

window.io = require('socket.io-client');

// HTTP connection to the API
const httpLink = createHttpLink({
    // You should use an absolute URL here
    uri: window.Laravel.APP_URL + ':3020/graphql',
})

// Cache implementation
const cache = new InMemoryCache()

// Create the apollo client
const apolloClient = new ApolloClient({
    link: httpLink,
    cache,
})

// Create the Vue App instance
const app = createApp({
    setup () {
        provide(DefaultApolloClient, apolloClient)
    },

    render: () => h(App),
})

app.use(router)
   .use(PerfectScrollbar)
   .use(BootstrapIconsPlugin)
   .mount('#shoutzor');
