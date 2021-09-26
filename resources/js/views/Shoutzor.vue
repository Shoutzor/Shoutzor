<template>
  <div>
    <header-top></header-top>

    <div id="wrapper" class="container-fluid">
        <div class="row">
          <header-menu></header-menu>

          <main id="main-content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <perfect-scrollbar ref="scroll">
                  <div class="page">
                      <div class="content">
                          <div class="container-xl">
                              <router-view></router-view>
                          </div>
                      </div>
                  </div>
              </perfect-scrollbar>
          </main>
        </div>
    </div>

    <media-player></media-player>
    <upload-manager></upload-manager>
  </div>
</template>

<script>
import HeaderTop from '@js/components/main/header/HeaderTop';
import HeaderMenu from '@js/components/main/header/HeaderMenu';
import MediaPlayer from '@js/components/main/player/MediaPlayer';
import UploadManager from '@js/components/main/upload/UploadManager';

export default {
  name: "Shoutzor",
  components: {
      HeaderTop,
      HeaderMenu,
      MediaPlayer,
      UploadManager
  },
  mounted() {
    //Add a scroll-event listener for when the user scrolls through the main content section
    this.$refs.scroll.scrollElement.addEventListener("scroll", this.onContentScroll);

    //Add file-drag event listeners
    document.addEventListener('dragover', this.onDragOver);
    document.addEventListener('dragleave', this.onDragLeave);
    document.addEventListener('drop', this.onDrop);
  },
  beforeUnmount() {
    //Remove the scroll event listener
    this.$refs.scroll.scrollElement.removeEventListener("scroll", this.onContentScroll);

    //Remove file-drag event listeners
    document.removeEventListener('dragover', this.onDragOver);
    document.removeEventListener('dragleave', this.onDragLeave);
    document.removeEventListener('drop', this.onDrop);
  },
  methods: {
    onContentScroll(event) {
      this.emitter.emit('main-content-scroll', {
        scrollX: event.target.scrollLeft,
        scrollY: event.target.scrollTop
      });
    },

    onDragOver(event) {
      event.preventDefault();
      this.emitter.emit('dragover', event);
    },

    onDragLeave(event) {
      event.preventDefault();
      this.emitter.emit('dragleave', event);
    },

    onDrop(event) {
      event.preventDefault();
      this.emitter.emit('drop', event);
    }
  }
}
</script>

<style lang="scss" scoped>
#wrapper {
    margin-top: $navbar-height;

    main {
        padding-bottom: $player-height;
    }
}

.ps {
  width: 100%;
  height: 100%;
}
</style>
