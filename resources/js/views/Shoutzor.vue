<template>
    <the-header :isAuthenticated="false" />

    <h1>test</h1>
    <div id="wrapper" class="container-fluid">
        <div class="row">
          <the-menu :isAuthenticated="false" />

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

    <media-player :volume="100" :playerStatus="'stopped'"/>
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
#wrapper main {
    background: url('@static/images/main-content-noise-bg.png');
}
</style>
