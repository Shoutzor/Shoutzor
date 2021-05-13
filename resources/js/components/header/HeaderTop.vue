<template>
    <header id="navbar-top" class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <router-link
                :to="{name: 'dashboard'}"
                class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0"
            >
                <img alt="Shoutz0r logo" class="navbar-brand-image" src="@static/images/shoutzor-logo-header.png">
            </router-link>

            <div class="header-search-container my-md-0">
                <header-search></header-search>
            </div>

            <div class="navbar-nav flex-row order-md-last">
                <div v-if="isAuthenticated && can('admin.access')" class="nav-item d-md-flex adminpanel-button">
                    <router-link
                        :to="{name: 'admin-dashboard'}"
                        class="btn btn-sm btn-outline-primary"
                    >Admin panel
                    </router-link>
                </div>

                <div v-if="isAuthenticated" class="nav-item dropdown">
                    <a class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown" href="#">
                        <div class="d-xl-block pl-2">
                            <div>{{ user.username }}</div>
                            <div class="mt-1 small text-muted">Administrator</div>
                        </div>
                    </a>
                    <header-user></header-user>
                </div>
                <div v-else class="nav-item dropdown">
                    <a class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown" href="#">
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
import {mapGetters} from 'vuex';

export default {
    name: 'headerTop',
    computed: mapGetters({
        isAuthenticated: 'isAuthenticated',
        user: 'getUser',
        can: 'can'
    }),
    created() {
        this.$bus.on('main-content-scroll', this.handleScroll);
    },
    beforeDestroy() {
        this.$bus.off('main-content-scroll', this.handleScroll);
    },
    methods: {
        handleScroll(event) {
            var navbar = document.querySelector('#navbar-top');

            if(event.scrollY > 0) {
                if(!navbar.classList.contains('showShadow')) {
                    navbar.classList.add('showShadow');
                }
            }
            else {
                if(navbar.classList.contains('showShadow')) {
                    navbar.classList.remove('showShadow');
                }
            }
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

        .header-search-container {
            position: absolute;
            left: 50%;
            width: $header-search-width;
            margin-left: -$header-search-width / 2;
        }

        .adminpanel-button {
            margin-right: 0.5rem;
            margin-left: -0.5rem;
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
        -webkit-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.2);
    }
}
</style>
