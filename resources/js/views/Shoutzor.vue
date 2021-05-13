<template>
    <div>
        <header-top v-on:scroll.native="handleScroll"></header-top>
        <header-menu></header-menu>

        <div id="main-content">
            <simplebar ref="scroll" class="simplebar-main" data-simplebar-auto-hide="true">
                <div class="page">
                    <div class="content">
                        <div class="container-xl">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </simplebar>
        </div>

        <media-player></media-player>
        <upload-manager></upload-manager>
    </div>
</template>

<script>
import simplebar from 'simplebar-vue';

export default {
    name: "Shoutzor", components: {
        simplebar
    }, mounted() {
        //Add a scroll-event listener for when the user scrolls through the main content section
        this.$refs.scroll.scrollElement.addEventListener("scroll", this.onContentScroll);

        //Add file-drag event listeners
        document.addEventListener('dragover', this.onDragOver);
        document.addEventListener('dragleave', this.onDragLeave);
        document.addEventListener('drop', this.onDrop);
    }, beforeDestroy() {
        //Remove the scroll event listener
        this.$refs.scroll.scrollElement.removeEventListener("scroll", this.onContentScroll);

        //Remove file-drag event listeners
        document.removeEventListener('dragover', this.onDragOver);
        document.removeEventListener('dragleave', this.onDragLeave);
        document.removeEventListener('drop', this.onDrop);
    }, methods: {
        onContentScroll(event) {
            this.$bus.emit('main-content-scroll', {scrollX: event.target.scrollLeft, scrollY: event.target.scrollTop});
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

<style lang="scss" scoped>
.simplebar-main {
    width: 100%;
    height: 100%;
}
</style>
