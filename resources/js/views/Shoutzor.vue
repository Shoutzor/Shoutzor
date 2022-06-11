<template>
    <the-header id="header" :isAuthenticated="false" />

    <div id="wrapper" class="d-flex flex-nowrap">
      <the-menu :isAuthenticated="false" class="d-flex flex-column flex-shrink-0 p-3" />

      <main id="main-content" class="d-flex flex-column flex-grow-1">
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

    <media-player id="media-player" :volume="100" :playerStatus="'stopped'"/>
</template>

<script>
import TheHeader from '@components/TheHeader';
import TheMenu from '@components/TheMenu';
import MediaPlayer from '@components/MediaPlayer';

export default {
  name: "Shoutzor",
  components: {
      TheHeader,
      TheMenu,
      MediaPlayer
  }
}
</script>

<style lang="scss" scoped>
#wrapper {
    margin-top: $navbar-height;
}

#wrapper main {
    background: url('@static/images/main-content-noise-bg.png');

    .ps {
        flex: 1 1 auto;
        height: 0; // Required to make content scrollable, see: https://stackoverflow.com/a/14964944/1024322
    }
}
</style>
