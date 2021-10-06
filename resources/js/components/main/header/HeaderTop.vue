<template>
    <header id="navbar-top" class="navbar navbar-dark fixed-top p-0">
        <div class="container-fluid">
            <router-link
                :to="{name: 'dashboard'}"
                class="navbar-brand"
            >
                <img alt="Shoutz0r logo" class="navbar-brand-image filter-invert" src="@static/images/shoutzor-logo-header.png">
            </router-link>
            <div class="d-flex justify-content-center">
                <header-search></header-search>
            </div>
            <ul v-if="isAuthenticated" class="d-flex justify-content-end nav">
                <li class="nav-item dropdown">
                    <a class="nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div>{{ user.username}}</div>
                        <div class="mt-1 small text-muted">Administrator</div>
                    </a>
                    <header-user></header-user>
                </li>
            </ul>
            <ul v-else class="d-flex justify-content-end nav">
                <li class="nav-item dropdown">
                    <a class="nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Login / Register
                    </a>
                    <header-login></header-login>
                </li>
            </ul>
            <div v-if="isAuthenticated && can('admin.access')" class="d-flex justify-content-end nav">
                <router-link
                    :to="{name: 'admin-dashboard'}"
                    class="btn btn-sm btn-outline-primary"
                >Admin panel
                </router-link>
            </div>
        </div>
    </header>
</template>

<script>
import { mapGetters } from 'vuex';
import HeaderUser from './HeaderUser';
import HeaderLogin from "./HeaderLogin";
import HeaderSearch from "./HeaderSearch";

export default {
    name: 'headerTop',
    components: {
        HeaderUser,
        HeaderLogin,
        HeaderSearch
    },
    computed: mapGetters({
        isAuthenticated: 'isAuthenticated',
        user: 'getUser',
        can: 'can'
    })
}
</script>

<style lang="scss">
@use "sass:math";

.dropdown .dropdown-menu {
    width: 250px
}

#navbar-top {
    width: 100%;
    z-index: 999;
    background: $body-bg;
    -webkit-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.2);
    box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.2);

    @include media-breakpoint-up(lg) {
        position: fixed;
        top: 0;
        height: $navbar-height;
    }

    .header-search-container {
        display: flex;
        position: absolute;
        left: 50%;
        width: $header-search-width;
        margin-left: math.div(-$header-search-width, 2);

        @media (max-width: map-get($grid-breakpoints, lg)) {
            position: relative;
            left: 0;
            width: 100%;
            margin-left: 0;
        }

        form {
            flex-grow: 1;
        }
    }

    .adminpanel-button {
        margin-right: 0.5rem;
        margin-left: -0.5rem;
    }

    .navbar-brand {
        -webkit-filter: none;
        filter: none;

        @include media-breakpoint-up(lg) {
            display: flex;
            justify-content: center;
            width: $sidebar-width;
            height: $navbar-height;
            margin: 0;
            padding: 0;
        }

        .navbar-brand-image {
            padding: 8px;
        }
    }
}
</style>
