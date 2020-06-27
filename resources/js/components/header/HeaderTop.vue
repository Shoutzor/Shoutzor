<template>
    <header class="navbar navbar-expand-lg" id="navbar-top">
        <div class="container-fluid">
            <a href="." class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0">
                <img src="@static/images/shoutzor-logo-header.png" alt="Shoutz0r logo" class="navbar-brand-image">
            </a>
            <div class="my-2 my-md-0">
                <header-search></header-search>
            </div>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-md-flex mr-3">
                    <router-link
                        :to="{name: 'admin'}"
                        class="btn btn-sm btn-outline-primary"
                        >Admin panel</router-link>
                </div>

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
    import $ from 'jquery';
    import { VueBus } from 'vue-bus';

    export default {
        name: 'headerTop',
        components: {
        },
        created() {
            this.$bus.on('main-content-scroll', this.handleScroll);
        },
        beforeDestroy() {
            this.$bus.off('main-content-scroll', this.handleScroll);
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
            }
        }
    }
</script>

<style scoped lang="scss">
    .simplebar-main {
        width: 100%;
        height: 100%;
    }
</style>
