import Vue from "vue";
import VueRouter from "vue-router";

import DashboardView from "@/views/Dashboard/index";

Vue.use(VueRouter);

const Foo = { template: '<div>Artist</div>' };
const Bar = { template: '<div>Search</div>' };

//Routes
const routes = [
    {
        name: 'dashboard',
        path: '/',
        component: DashboardView
    },
    {
        name: 'artist',
        path: '/artist',
        component: Foo
    },
    {
        name: 'search',
        path: '/search',
        component: Bar
    }
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

export default router;
