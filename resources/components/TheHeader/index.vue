<template>
    <header id="navbar-top" class="navbar navbar-dark fixed-top p-0">
        <div class="container-fluid">
            <router-link :to="{name: 'dashboard'}" class="navbar-brand">
                <img alt="logo" class="navbar-brand-image filter-invert" src="@static/images/shoutzor-logo-header.png">
            </router-link>
            <ul v-if="isAuthenticated" class="d-flex justify-content-end nav">
                <li class="nav-item dropdown">
                    <a class="nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <div>{{ user.username}}</div>
                        <div class="mt-1 small text-muted">Administrator</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dropdown">
                        <router-link :to="{name: 'profile'}" class="dropdown-item">
                            Profile
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" @click.prevent="$emit('logout')">Logout</a>
                    </div>
                </li>
            </ul>
            <ul v-else class="d-flex justify-content-end nav">
                <li class="nav-item dropdown">
                    <a class="nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Login / Register
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark auth-dropdown">
                        <login-form />

                        <div class="dropdown-divider"></div>

                        <button class="btn btn-secondary" type="button">Register</button>
                    </div>
                </li>
            </ul>
            <div v-if="isAuthenticated && isAdministrator" class="d-flex justify-content-end nav">
                <base-button class="btn-sm btn-outline-primary">Admin panel</base-button>
            </div>
        </div>
    </header>
</template>

<script>
import BaseButton from "@components/BaseButton";
import LoginForm from "@components/LoginForm";

export default {
    name: 'the-header',
    components: {
        BaseButton,
        LoginForm
    },
    props: {
        isAuthenticated: {
            type: Boolean,
            required: false,
            default: false
        },
        isAdministrator: {
            type: Boolean,
            required: false,
            default: false
        },
        user: {
            type: Object,
            required: false,
            default: null
        }
    }
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
