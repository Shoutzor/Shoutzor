import Vue          from "vue";
import VueRouter    from "vue-router";

Vue.use(VueRouter);

//Views
import DashboardView        from "@js/views/main/dashboard";
import UploadView           from "@js/views/main/upload";
import UserSettingsView     from "@js/views/user/settings";
import AdminView            from "@js/views/admin/index";
import AdminDashboard       from "@js/views/admin/dashboard";
import AdminPackages        from "@js/views/admin/packages";

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
        name: 'profile',
        path: '/profile',
        component: UserSettingsView
    },
    {
        name: 'admin',
        path: '/admin',
        component: AdminView,
        children: [
            {
                name: 'admin-dashboard',
                path: 'dashboard',
                component: AdminDashboard
            },
            {
                name: 'admin-packages',
                path: 'packages',
                component: AdminPackages
            }
        ]
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
