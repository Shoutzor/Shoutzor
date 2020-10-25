<template>
    <header class="navbar navbar-expand-lg" id="navbar-top">
        <div class="container-fluid">
            <router-link
                :to="{name: 'dashboard'}"
                class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0"
            >
                <img src="@static/images/shoutzor-logo-header.png" alt="Shoutz0r logo" class="navbar-brand-image">
            </router-link>

            <div class="my-2 my-md-0">
                <header-search></header-search>
            </div>

            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-md-flex mr-3" v-if="$isAuthenticated">
                    <router-link
                        :to="{name: 'admin-dashboard'}"
                        class="btn btn-sm btn-outline-primary"
                        >Admin panel</router-link>
                </div>

                <div class="nav-item dropdown" v-if="$isAuthenticated">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                        <div class="d-xl-block pl-2">
                            <div>{{ $getUser().username }}</div>
                            <div class="mt-1 small text-muted">Administrator</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <router-link
                            :to="{name: 'profile'}"
                            class="dropdown-item"
                        >
                            Profile
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <router-link
                            :to="{name: 'profile'}"
                            class="dropdown-item"
                        >
                            Logout
                        </router-link>
                    </div>
                </div>
                <div class="nav-item dropdown" v-else>
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                        <div class="d-xl-block pr-2">
                            <div>Login / Register</div>
                        </div>
                    </a>

                    <header-login></header-login>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    export default {
        name: 'headerTop',
        data() {
            return {
                isAuthenticated: false,
                user: null
            }
        },
        created() {
            this.$bus.on('main-content-scroll', this.handleScroll);
            this.$bus.on('auth-status', this.handleAuthStatus);
        },
        beforeDestroy() {
            this.$bus.off('main-content-scroll', this.handleScroll);
            this.$bus.off('auth-status', this.handleAuthStatus);
        },
        methods: {
            handleScroll(event) {
                var navbar = document.querySelector('#navbar-top');

                if (event.scrollY > 0) {
                    if (!navbar.classList.contains('showShadow')) {
                        navbar.classList.add('showShadow');
                    }
                } else if (navbar.classList.contains('showShadow')) {
                    navbar.classList.remove('showShadow');
                }
            },

            handleAuthStatus(event) {
                this.isAuthenticated = event.isAuthenticated;
                this.user = event.user;
            }
        }
    }
</script>

<style lang="scss">
    #navbar-top {
        width: 100%;
        z-index: 999;
        background: $body-bg;
        transition: box-shadow 0.2s ease;
        @media (min-width: map-get($grid-breakpoints, md)) {
            position: fixed;
            top: 0;
            height: $navbar-height;
        }

        .container-fluid {
            @media (min-width: map-get($grid-breakpoints, md)) {
                padding-left: 0;
            }

            .navbar-brand {
                -webkit-filter: none;
                filter: none;
                @media (min-width: map-get($grid-breakpoints, md)) {
                    display: flex;
                    justify-content: center;
                    width: $sidebar-width;
                    height: $navbar-height;
                    margin: 0;
                    padding: 0;
                }

                img {
                    -webkit-filter: brightness(0) invert(1);
                    filter: brightness(0) invert(1);
                }
            }
        }

        &.showShadow {
            -webkit-box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.2);
            -moz-box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.2);
            box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.2);
        }
    }
</style>
