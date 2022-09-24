<template>
    <nav id="navbar-left" class="d-md-block col-12 col-md-4 col-lg-2 sidebar collapse">
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
    methods: {
        canAccess(routeName) {
            let r = this.getRoute(routeName);

            if(r) {
                let m = r.meta;

                if("requiresPermission" in m) {
                    return this.auth.can(m.requiresPermission);
                }

                if("requiresAuth" in m && m.requiresAuth === true) {
                    return this.isAuthenticated();
                }
            }

            return false;
        },
        getRoute(routeName) {
            return this.routesObj.find(x => x.name === routeName) || null;
        }
    },
    computed: {
        isAuthenticated() {
            return this.auth.isAuthenticated;
        }
    }
}
</script>
