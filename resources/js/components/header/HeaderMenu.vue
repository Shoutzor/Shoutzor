<template>
        <aside class="navbar navbar-vertical navbar-expand-lg" id="navbar-left">
            <simplebar data-simplebar-auto-hide="true" class="simplebar-main">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-left-menu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-left-menu">
                        <span class="navbar-text pt-lg-3">Music zone</span>
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <router-link
                                    :to="{name: 'home'}"
                                    class="nav-link"
                                >
                                    <span class="nav-link-icon">
                                        <font-awesome-icon
                                            :icon="['fa', 'podcast']"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">Dashboard</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    :to="{name: 'home'}"
                                    class="nav-link"
                                >
                                    <span class="nav-link-icon">
                                        <font-awesome-icon
                                            :icon="['fa', 'history']"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">History</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    :to="{name: 'home'}"
                                    class="nav-link"
                                >
                                    <span class="nav-link-icon">
                                        <font-awesome-icon
                                            :icon="['fa', 'star']"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">Most Played</span>
                                </router-link>
                            </li>
                        </ul>
                        <span class="navbar-text pt-lg-3">Your zone</span>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <router-link
                                    :to="{name: 'home'}"
                                    class="nav-link"
                                >
                                    <span class="nav-link-icon">
                                        <font-awesome-icon
                                            :icon="['fas', 'upload']"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">Upload manager</span>
                                </router-link>
                            </li>
                        </ul>

                        <p class="navbar-text align-bottom text-gray-dark">Powered by <a href="https://github.com/xorinzor/shoutz0r" class="text-gray-dark">Shoutz0r</a></p>
                    </div>
                </div>
            </simplebar>
        </aside>
</template>

<script>
    import simplebar from 'simplebar-vue';
    import HeaderSearch from "./HeaderSearch";

    export default {
        name: 'headerMenu',
        components: {
            HeaderSearch,
            simplebar
        }
    }
</script>

<style scoped lang="scss">
    .simplebar-main {
        width: 100%;
        height: 100%;
    }
</style>
