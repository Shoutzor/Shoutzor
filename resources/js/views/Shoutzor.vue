<template>
  <template>
    <header-top />

    <div id="wrapper" class="container-fluid">
        <div class="row">
          <header-menu />

          <main id="main-content" class="col">
              <perfect-scrollbar ref="scroll">
                  <div class="page">
                      <div class="content">
                          <div class="container-fluid">
                              <router-view />
                          </div>
                      </div>
                  </div>
              </perfect-scrollbar>
          </main>
        </div>
    </div>

    <media-player />
  </template>
</template>

<script>
import HeaderTop from '@js/components/main/header/HeaderTop';
import HeaderMenu from '@js/components/main/header/HeaderMenu';
import MediaPlayer from '@components/MediaPlayer';

export default {
  name: "Shoutzor",
  components: {
      HeaderTop,
      HeaderMenu,
      MediaPlayer
  }
}
</script>

<style lang="scss" scoped>
#wrapper main {
    background: url('@static/images/main-content-noise-bg.png');
}
</style>
