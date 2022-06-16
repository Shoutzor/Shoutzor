<template>
    <header id="navbar-top" class="navbar navbar-dark fixed-top p-0">
        <div class="container-fluid">
            <router-link :to="{name: 'dashboard'}" class="navbar-brand">
                <img alt="logo" class="navbar-brand-image filter-invert" src="@static/images/shoutzor-logo-header.png">
            </router-link>
            <ul v-if="isAuthenticated === true" class="d-flex justify-content-end nav">
                <li class="nav-item dropdown">
                    <a class="nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                       role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <div>{{ user.username }}</div>
                        <div v-if="user.is_admin" class="mt-1 small text-muted">Administrator</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dropdown">
                        <router-link :to="{name: 'profile'}" class="dropdown-item">
                            Profile
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" @click.prevent="logout">Logout</a>
                    </div>
                </li>
            </ul>
            <ul v-else class="d-flex justify-content-end nav">
                <li class="nav-item dropdown">
                    <a class="nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                       role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Login / Register
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark auth-dropdown">
                        <login-form/>
                    </div>
                </li>
            </ul>
            <div v-if="isAuthenticated && user.is_admin" class="d-flex justify-content-end nav">
                <base-button class="btn-sm btn-outline-primary">Admin panel</base-button>
            </div>
        </div>
    </header>
</template>

<script>
import "./TheHeader.scss";

import BaseButton from "@components/BaseButton";
import LoginForm from "@components/LoginForm";

export default {
    name: 'the-header',
    components: {
        BaseButton,
        LoginForm
    },
    data() {
        return {
            loading: false,
            isAuthenticated: this.auth.isAuthenticated,
            user: this.auth.user
        }
    },
    methods: {
        logout() {
            this.loading = true;

            this.auth.logout()
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>
