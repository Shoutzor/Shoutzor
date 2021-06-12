import Vue from "vue";
import VueRouter from "vue-router";

//Views
import InstallerStartView from "@js/views/installer/start";

Vue.use(VueRouter);

//Routes
const routes = [{
    name: 'installer',
    path: '/',
    component: InstallerStartView,
    children: [{
        name: 'installer-start',
        path: 'start',
        component: InstallerStartView
    }]
}];

const router = new VueRouter({
    routes // short for `routes: routes`
});

export default router;
