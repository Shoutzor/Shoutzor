<template>
    <header id="navbar-top" class="navbar navbar-dark flex-md-nowrap sticky-top p-0">
        <div class="container-fluid">
            <router-link :to="{name: 'dashboard'}" class="navbar-brand">
                <img alt="logo" class="navbar-brand-image filter-invert" src="@static/images/shoutzor-logo-header.png">
            </router-link>
            <ul class="d-flex justify-content-end nav">
                <template v-if="isAuthenticated">
                    <li class="nav-item dropdown">
                        <a class="d-flex align-items-center nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                           role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <div class="d-inline-block">
                                <div>{{ user.username }}</div>
                                <div v-if="user.is_admin" class="small text-muted">Administrator</div>
                                <div v-else class="small text-muted">User</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dropdown">
                            <router-link :to="{name: 'profile'}" class="dropdown-item">
                                Profile
                            </router-link>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" @click.prevent="logout">Logout</a>
                        </div>
                    </li>
                    <li v-if="user.is_admin" class="nav-item d-flex align-items-center justify-content-center">
                        <base-button class="btn-sm btn-outline-primary">Admin panel</base-button>
                    </li>
                </template>
                <template v-else>
                    <li class="nav-item dropdown">
                        <a class="nav-link link-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                           role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            Login / Register
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark auth-dropdown">
                            <login-form/>
                        </div>
                    </li>
                </template>
            </ul>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-left" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
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
            loading: false
        }
    },
    computed: {
        isAuthenticated() { return this.auth.isAuthenticated; },
        user() { return this.auth.user; }
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
