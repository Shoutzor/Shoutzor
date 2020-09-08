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

        <authentication-manager></authentication-manager>
        <media-player></media-player>
        <upload-manager></upload-manager>
    </div>
</template>

<script>
    import simplebar from 'simplebar-vue';

    export default {
        name: "App",
        components: {
            simplebar
        },
        mounted() {
            //Add a scroll-event for when the user scrolls through the main content section
            this.$refs.scroll.scrollElement.addEventListener("scroll", this.onContentScroll);

            //Add file-drag events
            document.addEventListener('dragover', this.onDragOver);
            document.addEventListener('dragleave', this.onDragLeave);
            document.addEventListener('drop', this.onDrop);
        },
        methods: {
            onContentScroll(event) {
                this.$bus.emit('main-content-scroll', { scrollX: event.target.scrollLeft, scrollY: event.target.scrollTop });
            },

            onDragOver(event) {
                event.preventDefault();
                this.$bus.emit('dragover', event);
            },

            onDragLeave(event) {
                event.preventDefault();
                this.$bus.emit('dragleave', event);
            },

            onDrop(event) {
                event.preventDefault();
                this.$bus.emit('drop', event);
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
