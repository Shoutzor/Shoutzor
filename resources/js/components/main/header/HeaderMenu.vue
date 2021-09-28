<template>
    <nav id="navbar-left" class="fixed d-lg-block sidebar collapse">
        <div class="position-sticky">
            <div id="navbar-left-menu">
                <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">Music zone</span>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <router-link
                            :to="{name: 'dashboard'}"
                            class="nav-link"
                        >
                            <b-icon-house></b-icon-house>
                            Dashboard
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            :to="{name: 'history'}"
                            class="nav-link"
                        >
                            <b-icon-clock-history></b-icon-clock-history>
                            History
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            :to="{name: 'popular'}"
                            class="nav-link"
                        >
                            <b-icon-star></b-icon-star>
                            Most Played
                        </router-link>
                    </li>
                </ul>
                <span v-if="isAuthenticated" class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">Your zone</span>
                <ul v-if="isAuthenticated" class="nav flex-column">
                    <li v-if="can('website.upload')" class="nav-item">
                        <router-link
                            :to="{name: 'upload'}"
                            class="nav-link"
                        >
                            <b-icon-cloud-upload></b-icon-cloud-upload>
                            Upload manager
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex';
import HeaderSearch from "./HeaderSearch";

export default {
    name: 'headerMenu',
    computed: mapGetters({
        isAuthenticated: 'isAuthenticated',
        can: 'can'
    }),
    components: {
        HeaderSearch
    }
}
</script>

<style lang="scss" scoped>
#navbar-left {
    background: $body-bg;
    -webkit-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.1);
    box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.1);
    padding-top: 0;
    z-index: 999;

    @include media-breakpoint-up(lg) {
        padding-top: 1rem;
        width: 250px;
        min-height: calc(100vh - #{$navbar-height});
    }

    .align-bottom {
        margin-top: auto;
    }

    #navbar-left-menu {
        padding-top: 0;

        .nav {
            flex-grow: 0;

            .nav-item {
                .nav-link {
                    color: $gray;

                    &.router-link-exact-active {
                        color: $white !important;
                    }
                }

                .svg {
                    width: 1.3rem;
                    height: 1.3rem;
                    margin: 5px 7px 5px 0;
                }
            }
        }
    }
}
</style>
