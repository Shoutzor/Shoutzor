<template>
    <the-header id="header" :isAuthenticated="false" />

    <div id="wrapper" class="d-flex flex-nowrap">
      <the-menu :isAuthenticated="false" class="flex-column flex-shrink-0 p-3" />

      <main id="main-content" class="d-flex flex-column flex-grow-1">
          <perfect-scrollbar ref="scroll">
              <div class="container">
                  <router-view />
              </div>
          </perfect-scrollbar>
      </main>
    </div>

    <media-player id="media-player" :volume="100" :playerStatus="'stopped'"/>
    <upload-manager></upload-manager>
</template>

<script>
import TheHeader from '@components/TheHeader';
import TheMenu from '@components/TheMenu';
import MediaPlayer from '@components/MediaPlayer';
import UploadManager from "@components/UploadManager";

export default {
  name: "Shoutzor",
  components: {
      TheHeader,
      TheMenu,
      MediaPlayer,
      UploadManager
  }
}
</script>

<style lang="scss" scoped>
#wrapper {
    padding-top: calc($navbar-height + 1.5rem);
    padding-bottom: 0.5rem;
}

#wrapper main {
    .ps {
        flex: 1 1 auto;
        height: 0; // Required to make content scrollable, see: https://stackoverflow.com/a/14964944/1024322
    }
}
</style>
