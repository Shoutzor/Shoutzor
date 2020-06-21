<template>
    <aside class="navbar navbar-vertical navbar-expand-lg" id="navbar-left">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-left-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-left-menu">
                <span class="navbar-text pt-lg-3">
                        test
                            </span>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <router-link
                            :to="{name: 'home'}"
                            class="nav-link"
                        >
                            <span class="nav-link-title">Home</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            :to="{name: 'home'}"
                            class="nav-link"
                        >
                            <span class="nav-link-title">History</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            :to="{name: 'home'}"
                            class="nav-link"
                        >
                            <span class="nav-link-title">Most Played</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            :to="{name: 'home'}"
                            class="nav-link"
                        >
                            <span class="nav-link-title">Upload manager</span>
                        </router-link>
                    </li>
                </ul>

                <p class="navbar-text text-gray-dark">Powered by <a href="https://github.com/xorinzor/shoutz0r" class="text-gray-dark">Shoutz0r</a></p>
            </div>
        </div>
    </aside>
</template>

<script>
    import HeaderSearch from "./HeaderSearch";

    export default {
        name: 'headerMenu',
        components: {
            HeaderSearch
        }
    }
</script>
