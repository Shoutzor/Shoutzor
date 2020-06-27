import Vue          from "vue";
import VueRouter    from "vue-router";

Vue.use(VueRouter);

//Views
import DashboardView    from "@js/views/Dashboard/index";
import AdminView        from "@js/views/Admin/index";

//Routes
const routes = [
    {
        name: 'dashboard',
        path: '/',
        component: DashboardView
    },
    {
        name: 'admin',
        path: '/admin',
        component: AdminView
    },
    {
        name: 'artist',
        path: '/artist',
        component: DashboardView
    },
    {
        name: 'search',
        path: '/search',
        component: DashboardView
    }
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

export default router;
