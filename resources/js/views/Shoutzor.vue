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
import UploadManager from '@js/components/main/upload/UploadManager';
import MediaPlayer from '@components/MediaPlayer';

export default {
  name: "Shoutzor",
  components: {
      HeaderTop,
      HeaderMenu,
      MediaPlayer,
      UploadManager
  }
}
</script>

<style lang="scss" scoped>
#wrapper main {
    background: url('@static/images/main-content-noise-bg.png');
}
</style>
