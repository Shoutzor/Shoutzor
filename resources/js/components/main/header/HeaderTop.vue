<template>
    <header id="navbar-top" class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <router-link
            :to="{name: 'dashboard'}"
            class="navbar-brand col-md-3 col-lg-2 me-0 px-3"
        >
            <img alt="Shoutz0r logo" class="navbar-brand-image filter-invert" src="@static/images/shoutzor-logo-header.png">
        </router-link>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <header-search></header-search>
        </div>
        <div v-if="isAuthenticated" class="dropdown me-lg-1">
            <a class="text-reset dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <div class="d-xl-block pl-2">
                    <div>{{ user.username }}</div>
                    <div class="mt-1 small text-muted">Administrator</div>
                </div>
            </a>
            <header-user></header-user>
        </div>
        <div v-else class="dropdown me-lg-1">
            <a class="text-reset dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <div class="d-xl-block pr-2">
                    <div>Login / Register</div>
                </div>
            </a>
            <header-login></header-login>
        </div>
        <div v-if="isAuthenticated && can('admin.access')" class="me-lg-0">
            <router-link
                :to="{name: 'admin-dashboard'}"
                class="btn btn-sm btn-outline-primary"
            >Admin panel
            </router-link>
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
@use 'sass:math';

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
