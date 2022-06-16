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
<!--                        <div>{{ user.username }}</div>-->
                        <div class="mt-1 small text-muted">Administrator</div>
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
            <div v-if="isAuthenticated && isAdministrator" class="d-flex justify-content-end nav">
                <base-button class="btn-sm btn-outline-primary">Admin panel</base-button>
            </div>
        </div>
    </header>
</template>

<script>
import "./TheHeader.scss";

import BaseButton from "@components/BaseButton";
import LoginForm from "@components/LoginForm";
import {useMutation} from "@vue/apollo-composable";
import { isLoggedInVar } from "@graphql/cache";
import { LOGOUT_MUTATION } from "@graphql/auth";

export default {
    name: 'the-header',
    components: {
        BaseButton,
        LoginForm
    },
    setup(props, {emit}) {
        const {mutate: logout, loading, error, onDone} = useMutation(LOGOUT_MUTATION, {
            fetchPolicy: 'no-cache'
        });

        onDone(result => {
            localStorage.removeItem('token');
            isLoggedInVar.value = false;
        });

        return {
            isAuthenticated: isLoggedInVar,
            logout,
            loading,
            error
        }
    },
    props: {
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
