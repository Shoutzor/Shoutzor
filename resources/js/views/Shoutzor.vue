<template>
  <div>
    <header-top></header-top>

    <div id="wrapper" class="container-fluid">
        <div class="row">
          <header-menu></header-menu>

          <main id="main-content" class="col">
              <perfect-scrollbar ref="scroll">
                  <div class="page">
                      <div class="content">
                          <div class="container-fluid">
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
    //Add file-drag event listeners
    document.addEventListener('dragover', this.onDragOver);
    document.addEventListener('dragleave', this.onDragLeave);
    document.addEventListener('drop', this.onDrop);
  },
  beforeUnmount() {
    //Remove file-drag event listeners
    document.removeEventListener('dragover', this.onDragOver);
    document.removeEventListener('dragleave', this.onDragLeave);
    document.removeEventListener('drop', this.onDrop);
  },
  methods: {
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
        background: url('@static/images/main-content-noise-bg.png');
    }
}

.ps {
  width: 100%;
  height: calc(100vh - (#{$navbar-height} + #{$player-height}));
}
</style>
