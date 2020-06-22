<template>
    <div>
        <header-top></header-top>
        <header-menu></header-menu>

        <div id="main-content">
            <simplebar data-simplebar-auto-hide="true" class="simplebar-main">
                <div class="page">
                    <div class="content">
                        <div class="container-xl">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </simplebar>
        </div>
    </div>
</template>

<script>
    import simplebar from 'simplebar-vue';

    export default {
        name: "App",
        components: {
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
