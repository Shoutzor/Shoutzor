<template>
        <aside class="navbar navbar-vertical navbar-expand-lg" id="navbar-left">
            <simplebar data-simplebar-auto-hide="true" class="simplebar-menu">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-left-menu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-left-menu">
                        <span class="navbar-text pt-lg-3">Music zone</span>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <router-link
                                    :to="{name: 'dashboard'}"
                                    class="nav-link"
                                >
                                    <span class="nav-link-icon">
                                        <font-awesome-icon
                                            :icon="['fa', 'podcast']"
                                        ></font-awesome-icon>
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
                                        <font-awesome-icon
                                            :icon="['fa', 'history']"
                                        ></font-awesome-icon>
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
                                        <font-awesome-icon
                                            :icon="['fa', 'star']"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">Most Played</span>
                                </router-link>
                            </li>
                        </ul>
                        <span class="navbar-text pt-lg-3" v-if="isAuthenticated">Your zone</span>
                        <ul class="navbar-nav" v-if="isAuthenticated">
                            <li class="nav-item">
                                <router-link
                                    :to="{name: 'upload'}"
                                    class="nav-link"
                                >
                                    <span class="nav-link-icon">
                                        <font-awesome-icon
                                            :icon="['fas', 'upload']"
                                        ></font-awesome-icon>
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
            isAuthenticated: 'isAuthenticated'
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
        -webkit-box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.1);
        box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.1);

        .container {
            display: flex;
            margin-left: initial;

            @media (min-width: map-get($grid-breakpoints, lg)) {
                height: 100%;
                margin-left: auto;
            }
        }

        @media (min-width: map-get($grid-breakpoints, md)) {
            top: $navbar-height;

            .navbar-nav {
                flex-grow: 0;
            }

            .align-bottom {
                margin-top: auto;
            }
        }


        a.nav-link.router-link-exact-active {
            color: #fff !important;
        }

        .nav-link-icon {
            width: 2.25rem;
            height: initial;
            font-size: 1.3rem;
            margin: 5px 0;
        }

        .navbar-text {
            color: #FFF;
            font-weight: bold;
        }

        @media (max-width: map-get($grid-breakpoints, lg)) {
            #navbar-left-menu {
                padding-top: $navbar-height;
            }
        }

        .simplebar-menu {
            width: 100%;
            height: 100%;
        }
    }
</style>
