<template>
    <the-header />

    <div id="wrapper" class="d-flex flex-nowrap">
        <the-menu :items="menuItemsToRender" class="flex-column flex-shrink-0 p-3"/>

        <main id="main-content" class="d-flex flex-column flex-grow-1">
            <perfect-scrollbar ref="scroll">
                <div class="container">
                    <router-view @vnodeMounted="updateScrollbar" @vnodeUpdated="updateScrollbar" />
                </div>
            </perfect-scrollbar>
        </main>
    </div>

    <div class="position-relative bottom-0 order-3">
        <the-modalmanager />
        <the-toastmanager />
    </div>

    <the-mediaplayer id="media-player" :volume="100" :playerStatus="'stopped'"/>
</template>

<script>
import TheHeader from '@components/TheHeader';
import TheMenu from '@components/TheMenu';
import TheMediaplayer from '@components/TheMediaplayer';
import TheToastmanager from "@components/TheToastmanager";
import TheModalmanager from "@components/TheModalmanager";

export default {
    name: "Shoutzor",
    components: {
        TheHeader,
        TheMenu,
        TheModalmanager,
        TheToastmanager,
        TheMediaplayer
    },
    data() {
        return {
            routes: this.$router.getRoutes(),
            /**
             * items to display in the left-hand menu
             * items in the menu will check if the route has required permissions configured, and only show if matched
             * structure is as follows:
             * type (ie: main or admin area) [
             *     section {
             *         name: "name of section"
             *         items: [
             *              {
             *                  name: "name of item to display in menu"
             *                  route: "name of route as configured in router"
             *                  icon: "icon to show in menu"
             *              }
             *         ]
             *     }
             * ]
             */
            menuItems: {
                main: [
                    {
                        name: "App zone",
                        items: [{
                            name: "Dashboard",
                            route: "dashboard",
                            icon: "b-icon-house-fill"
                        }, {
                            name: "History",
                            route: "history",
                            icon: "b-icon-clock-history"
                        }, {
                            name: "Most Played",
                            route: "popular",
                            icon: "b-icon-star"
                        }]
                    },
                    {
                        name: "User zone",
                        items: [{
                            name: "Upload manager",
                            route: "upload",
                            icon: "b-icon-cloud-upload"
                        }]
                    }
                ],
                admin: [
                    {
                        name: "Admin panel",
                        items: [{
                            name: "Dashboard",
                            route: "admin-dashboard",
                            icon: "b-icon-graph-up"
                        }, {
                            name: "Users",
                            route: "admin-users",
                            icon: "b-icon-graph-up"
                        }, {
                            name: "Roles",
                            route: "admin-roles",
                            icon: "b-icon-graph-up"
                        }]
                    }
                ]
            }
        }
    },
    watch: {
        // Warning: IDE's might say this is unused, but it's not. DO NOT REMOVE.
        // Will bring the page back to the top whenever the route is changed
        $route() {
            this.$refs.scroll.$el.scrollTop = 0;
        }
    },
    methods: {
        updateScrollbar() {
            this.$refs.scroll.update();
        },
        getRoute(routeName) {
            // Returns the Route object from vue-router
            return this.routes.find(x => x.name === routeName) || null;
        },
        canAccessRoute(routeName) {
            let r = this.getRoute(routeName);

            // If the route is not found, it's invalid. Don't show to the user.
            if(!r) {
                console.error(`Route ${routeName} not found`);
                return false;
            }

            // If the route is a redirect of a different route,
            // check the permissions of the route being redirected to
            if(r?.redirect?.name) {
                return this.canAccessRoute(r.redirect.name);
            }

            // Finally check if a "meta" property is set, this will contain any authorization settings
            if("meta" in r) {
                let m = r.meta;

                // If meta.requiresAuth is set, check if the user is authenticated
                if("requiresAuth" in m && m.requiresAuth === true && this.auth.isAuthenticated === false) {
                    return false;
                }

                // If meta.requiresPermission is set, check if the user has the configured permission
                if("requiresPermission" in m && this.auth.can(m.requiresPermission) === false) {
                    return false;
                }
            }

            // Route is valid & all requirements (if any) are matched. Can be shown to the user.
            return true;
        }
    },
    computed: {
        menuItemsToRender() {
            let items;

            // Check if we're in the admin panel
            if(this.$route.matched.some(route => route.name.includes('admin'))) {
                items = this.menuItems.admin;
            }
            else {
                items = this.menuItems.main;
            }

            let result = [];

            // Iterate over the menu items, this is before any authorization checks.
            items.forEach((section) => {
                let allowedSubItems = section.items.filter(item => this.canAccessRoute(item.route));
                if(allowedSubItems.length > 0) {
                    // Overwrite the section items with only the items the user has access to
                    section.items = allowedSubItems;

                    //Add the resulting section to our result array
                    result.push(section);
                }
            });

            // Return the resulting items
            return result;
        }
    }
}
</script>

<style lang="scss" scoped>
#wrapper #main-content {
    .ps {
        flex: 1 1 auto;
        height: 0; // Required to make content scrollable, see: https://stackoverflow.com/a/14964944/1024322

        .container {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
    }
}
</style>
