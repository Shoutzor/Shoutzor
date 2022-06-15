import {createRouter, createWebHashHistory} from "vue-router";

function loadView(view) {
    return () => import(`@js/views/${view}.vue`);
}

const router = createRouter({
    history: createWebHashHistory(),
    routes: [{
        name: 'dashboard',
        path: '/',
        component: loadView('main/dashboard')
    },
        {
            name: 'history',
            path: '/history',
            component: loadView('main/history')
        }, {
            name: 'popular',
            path: '/popular',
            component: loadView('main/dashboard')
        }, {
            name: 'upload',
            path: '/upload',
            component: loadView('main/upload'),
            meta: {requiresAuth: true}
        }, {
            name: 'artist',
            path: '/artist',
            component: loadView('main/dashboard')
        }, {
            name: 'album',
            path: '/album',
            component: loadView('main/dashboard')
        }, {
            name: 'search',
            path: '/search',
            component: loadView('main/dashboard')
        }, {
            name: 'profile',
            path: '/profile',
            component: loadView('main/dashboard'),
            meta: {requiresAuth: true}
        },
        /*{
            name: 'admin',
            path: '/admin',
            component: loadView('admin/index'),
            meta: {
                requiresAuth: true,
                requiresPermission: 'admin.access'
            },
            children: [{
                name: 'admin-dashboard',
                path: 'dashboard',
                component: loadView('admin/dashboard')
            }, {
                name: 'admin-users',
                path: 'users',
                component: loadView('admin/users')
            }, {
                name: 'admin-roles',
                path: 'roles',
                component: loadView('admin/roles'),
                children: [{
                    name: 'admin-roles-list',
                    path: 'list',
                    component: loadView('admin/roles/list')
                }, {
                    name: 'admin-roles-edit',
                    path: 'edit/:roleId',
                    component: loadView('admin/roles/edit'),
                    props: ({params}) => ({
                        roleId: Number.parseInt(params.roleId, 10) || null
                    })
                }]
            }, {
                name: 'admin-modules',
                path: 'modules',
                component: loadView('admin/modules')
            }]
        }*/
    ]
});

//Authentication check
/*router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.hasToken) {
            next()
            return
        }
        next('/')
    } else {
        next()
    }
});*/

export default (app) => {
    app.router = router;
    app.use(router);
}
