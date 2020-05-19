<template>
    <header class="navbar navbar-expand-md navbar-light">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="." class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3">
                <img src="/images/shoutzor-logo-header.png" alt="Shoutz0r logo" class="navbar-brand-image">
            </a>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-md-flex mr-3">
                    <router-link
                        :to="{name: 'admin'}"
                        class="btn btn-sm btn-outline-primary"
                        >Admin panel</router-link>
                </div>

                <header-notifications></header-notifications>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                        <div class="d-xl-block pl-2">
                            <div>Xorinzor</div>
                            <div class="mt-1 small text-muted">Administrator</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    import notifications from './HeaderNotifications';

    export default {
        name: 'headerTop',
        components: {
            notifications
        }
    }
</script>
