import Vue          from "vue";
import VueRouter    from "vue-router";

Vue.use(VueRouter);

//Views
import DashboardView    from "@js/views/main/dashboard";
import UploadView       from "@js/views/main/upload";
import UserSettingsView from "@js/views/user/settings";
import AdminView        from "@js/views/admin/index";

//Routes
const routes = [
    {
        name: 'dashboard',
        path: '/',
        component: DashboardView
    },
    {
        name: 'history',
        path: '/history',
        component: DashboardView
    },
    {
        name: 'popular',
        path: '/popular',
        component: DashboardView
    },
    {
        name: 'upload',
        path: '/upload',
        component: UploadView
    },
    {
        name: 'tv',
        path: '/tv',
        component: DashboardView
    },
    {
        name: 'profile',
        path: '/profile',
        component: UserSettingsView
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
