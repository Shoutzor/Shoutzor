<template>
    <div>
        <header-top v-on:scroll.native="handleScroll"></header-top>
        <header-menu></header-menu>

        <div id="main-content">
            <simplebar data-simplebar-auto-hide="true" class="simplebar-main" ref="scroll">
                <div class="page">
                    <div class="content">
                        <div class="container-xl">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </simplebar>
        </div>

        <audio-player></audio-player>
    </div>
</template>

<script>
    import simplebar from 'simplebar-vue';
    import { VueBus } from 'vue-bus';

    export default {
        name: "App",
        components: {
            simplebar
        },
        mounted() {
            //Add a listener for when the user scrolls through the main content section, that emits a scroll event
            //for other components to hook into
            this.$refs.scroll.scrollElement.addEventListener("scroll", this.onContentScroll);
        },
        methods: {
            onContentScroll(event) {
                this.$bus.emit('main-content-scroll', { scrollX: event.target.scrollLeft, scrollY: event.target.scrollTop });
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
