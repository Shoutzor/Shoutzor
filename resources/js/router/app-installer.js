import Vue from "vue";
import VueRouter from "vue-router";

//Views
import InstallerStartView from "@js/views/installer/start";
import InstallerHealthCheckView from "@js/views/installer/healthcheck";
import InstallerDatabaseView from "@js/views/installer/database";
import InstallerFinishView from "@js/views/installer/finish";

Vue.use(VueRouter);

//Routes
const routes = [{
    name: 'installer-start',
    path: '/',
    component: InstallerStartView
}, {
    name: 'installer-healthcheck',
    path: '/healthcheck',
    component: InstallerHealthCheckView
}, {
    name: 'installer-database',
    path: '/database',
    component: InstallerDatabaseView
}, {
    name: 'installer-finish',
    path: '/finish',
    component: InstallerFinishView
}];

const router = new VueRouter({
    routes // short for `routes: routes`
});

export default router;
