import { createRouter, createMemoryHistory } from "vue-router";

//Views
import InstallerStartView from "@js/views/installer/start";
import InstallerHealthCheckView from "@js/views/installer/healthcheck";
import InstallerDatabaseView from "@js/views/installer/database";
import InstallerSetupView from "@js/views/installer/setup";
import InstallerFinishView from "@js/views/installer/finish";

const router = createRouter({
    hashbang: true,
    history: createMemoryHistory(),
    routes: [
        {
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
            name: 'installer-setup',
            path: '/setup',
            component: InstallerSetupView
        }, {
            name: 'installer-finish',
            path: '/finish',
            component: InstallerFinishView
        }
    ]
});

export default (app) => {
    app.router = router;
    app.use(router);
}