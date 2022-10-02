import {createRouter, createWebHashHistory} from "vue-router";

function loadView(view) {
    return () => import(`@js/views/${view}.vue`);
}

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            name: 'dashboard',
            path: '/',
            component: loadView('main/dashboard'),
            meta: {
                requiresPermission: "website.access"
            }
        },
        {
            name: 'history',
            path: '/history',
            component: loadView('main/history'),
            meta: {
                requiresPermission: "website.access"
            }
        }, {
            name: 'popular',
            path: '/popular',
            component: loadView('main/dashboard'),
            meta: {
                requiresPermission: "website.access"
            }
        }, {
            name: 'upload',
            path: '/upload',
            component: loadView('main/upload'),
            meta: {
                requiresPermission: "website.upload",
                requiresAuth: true
            }
        }, {
            name: 'artist',
            path: '/artist/:id',
            component: loadView('main/artist'),
            props: ({params}) => ({
                id: params.id || null
            }),
            meta: {
                requiresPermission: "website.access"
            }
        }, {
            name: 'album',
            path: '/album/:id',
            component: loadView('main/album'),
            props: ({params}) => ({
                id: params.id || null
            }),
            meta: {
                requiresPermission: "website.access"
            }
        }, {
            name: 'search',
            path: '/search',
            component: loadView('main/search'),
            meta: {
                requiresPermission: "website.search"
            }
        }, {
            name: 'profile',
            path: '/profile',
            component: loadView('main/dashboard'),
            meta: {
                requiresPermission: "website.profile",
                requiresAuth: true
            }
        },
        {
            name: 'admin',
            path: '/admin',
            redirect: {
                name: 'admin-dashboard'
            },
            meta: {
                requiresPermission: 'admin.access'
            },
            children: [
                {
                    name: 'admin-dashboard',
                    path: 'dashboard',
                    component: loadView('admin/dashboard'),
                    meta: {
                        requiresPermission: "admin.access",
                        requiresAuth: true
                    }
                }, {
                    name: 'admin-users',
                    path: 'users',
                    redirect: {
                        name: 'admin-users-list'
                    },
                    children: [
                        {
                            name: 'admin-users-list',
                            path: 'list',
                            component: loadView('admin/users/list'),
                            meta: {
                                requiresPermission: "admin.user.list",
                                requiresAuth: true
                            }
                        }
                    ]
                }, {
                    name: 'admin-roles',
                    path: 'roles',
                    redirect: {
                        name: 'admin-roles-list'
                    },
                    children: [
                        {
                            name: 'admin-roles-list',
                            path: 'list',
                            component: loadView('admin/roles/list'),
                            meta: {
                                requiresPermission: "admin.role.list",
                                requiresAuth: true
                            }
                        }, {
                            name: 'admin-roles-edit',
                            path: 'edit/:roleId',
                            component: loadView('admin/roles/edit'),
                            props: ({params}) => ({
                                roleId: Number.parseInt(params.roleId, 10) || null
                            }),
                            meta: {
                                requiresPermission: "admin.role.edit",
                                requiresAuth: true
                            }
                        }
                    ]
                }
            ]
        }
    ]
});

export default (app) => {
    app.router = router;
    app.use(router);
}
