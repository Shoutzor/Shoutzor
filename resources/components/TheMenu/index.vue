<template>
    <nav id="navbar-left" class="col-12 col-md-4 col-lg-2 sidebar collapse">
        <perfect-scrollbar ref="menuScroll">
            <div id="navbar-left-menu" class="position-sticky">
                <template v-for="(section, index) in items">
                    <span
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted"
                        :class="index > 0 ? 'mt-md-5' : ''"
                    >
                        {{ section.name }}
                    </span>
                    <ul class="nav flex-column">
                        <template v-for="item in section.items">
                            <template v-if="canAccess(item.route)">
                                <li class="nav-item">
                                    <router-link :to="{name: item.route}" class="nav-link">
                                        <component :is="item.icon" class="icon" />
                                        <span class="text ps-1">{{ item.name }}</span>
                                    </router-link>
                                </li>
                            </template>
                        </template>
                    </ul>
                </template>
            </div>
        </perfect-scrollbar>
    </nav>
</template>

<script>
import "./TheMenu.scss";

export default {
    name: 'the-menu',
    props: {
        items: {
            type: Array,
            required: false
        }
    },
    data() {
        return {
            routesObj: this.$router.getRoutes()
        }
    },
    mounted() {
        this.updateScrollbar();
    },
    updated() {
        this.updateScrollbar();
    },
    methods: {
        canAccess(routeName) {
            let r = this.getRoute(routeName);

            // If the route is a redirect of a different route,
            // check the permissions of the route being redirected to
            if(r?.redirect?.name) {
                return this.canAccess(r.redirect.name);
            }

            if(r) {
                let m = r.meta;

                if("requiresPermission" in m && this.auth.can(m.requiresPermission) === false) {
                    return false;
                }

                if("requiresAuth" in m && m.requiresAuth === true && this.isAuthenticated() === false) {
                    return false;
                }
            }

            return true;
        },
        getRoute(routeName) {
            return this.routesObj.find(x => x.name === routeName) || null;
        },
        updateScrollbar() {
            this.$refs.menuScroll.update();
        }
    },
    computed: {
        isAuthenticated() {
            return this.auth.isAuthenticated;
        }
    }
}
</script>
