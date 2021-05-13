<template>
    <aside id="navbar-left" class="navbar navbar-vertical navbar-expand-lg">
        <simplebar class="simplebar-menu" data-simplebar-auto-hide="true">
            <div class="container">
                <div id="navbar-left-menu" class="collapse navbar-collapse">
                    <span class="navbar-text pt-lg-3">Music zone</span>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link
                                :to="{name: 'dashboard'}"
                                class="nav-link"
                            >
                                    <span class="nav-link-icon">
                                        <home-icon></home-icon>
                                    </span>
                                <span class="nav-link-title">Dashboard</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{name: 'history'}"
                                class="nav-link"
                            >
                                    <span class="nav-link-icon">
                                        <history-icon></history-icon>
                                    </span>
                                <span class="nav-link-title">History</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{name: 'popular'}"
                                class="nav-link"
                            >
                                    <span class="nav-link-icon">
                                        <star-icon></star-icon>
                                    </span>
                                <span class="nav-link-title">Most Played</span>
                            </router-link>
                        </li>
                    </ul>
                    <span v-if="isAuthenticated" class="navbar-text pt-lg-3">Your zone</span>
                    <ul v-if="isAuthenticated" class="navbar-nav">
                        <li v-if="can('website.upload')" class="nav-item">
                            <router-link
                                :to="{name: 'upload'}"
                                class="nav-link"
                            >
                                    <span class="nav-link-icon">
                                        <cloud-upload-icon></cloud-upload-icon>
                                    </span>
                                <span class="nav-link-title">Upload manager</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </simplebar>
    </aside>
</template>

<script>
import {mapGetters} from 'vuex';
import simplebar from 'simplebar-vue';
import HeaderSearch from "./HeaderSearch";

export default {
    name: 'headerMenu',
    computed: mapGetters({
        isAuthenticated: 'isAuthenticated',
        can: 'can'
    }),
    components: {
        HeaderSearch,
        simplebar
    }
}
</script>

<style lang="scss">
#navbar-left {
    background: $light-mix;
    -webkit-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.1);
    box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.1);
    top: $navbar-height;

    .align-bottom {
        margin-top: auto;
    }

    .container {
        display: flex;
        margin-left: initial;
        height: auto;

        #navbar-left-menu {
            padding-top: 0;

            .navbar-text {
                color: #FFF;
                font-weight: bold;
            }

            .navbar-nav {
                flex-grow: 0;

                .nav-link-icon {
                    width: 1.5rem;
                    height: initial;
                    font-size: 1.3rem;
                    margin: 5px 7px 5px 0;
                }
            }
        }
    }

    a.nav-link.router-link-exact-active {
        color: #fff !important;
    }

    .simplebar-menu {
        width: 100%;
        height: 100%;
    }

    @media (max-width: map-get($grid-breakpoints, lg)) {
        top: 0;
        min-height: 0;
        padding-top: 0;
        padding-bottom: 0;

        .container {
            #navbar-left-menu {
                padding-top: 0.5rem;
            }
        }
    }
}
</style>
