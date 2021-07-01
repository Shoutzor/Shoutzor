<template>
  <shoutzor v-if="loaded && can('website.access')"></shoutzor>
  <login-screen v-else-if="loaded && can('website.access') === false"></login-screen>
  <load-screen v-else></load-screen>
</template>

<script>
import Vue from "vue";
import {mapGetters} from 'vuex';
import Shoutzor from "@js/views/Shoutzor";
import LoginScreen from "@js/components/main/login/LoginScreen";
import store from "@js/store/index";
import LoadScreen from "@js/components/global/loader/LoadScreen";

export default {
  name: "App",
  components: {
    LoadScreen,
    LoginScreen,
    Shoutzor
  },
  computed: mapGetters({
    can: 'can',
    hasToken: 'hasToken'
  }),
  data() {
    return {
      loaded: false
    }
  },

  /**
   * @emits app.ready when the Shoutzor views have finished initializing
   */
  created() {
    //Resume an existing loginsession if the user has a valid token
    const resumeSession = (this.hasToken) ? store.dispatch('resumeSession') : null;

    // Update the guest role
    const updateGuestRole = store.dispatch('updateGuestRole');

    //Wait for both updates to finish loading
    Promise.all([resumeSession, updateGuestRole]).finally(() => {
      this.loaded = true;
      Vue.bus.emit('app.ready');
    })
  }
}
</script>

<style lang="scss" scoped>
.simplebar-main {
  width: 100%;
  height: 100%;
}
</style>
