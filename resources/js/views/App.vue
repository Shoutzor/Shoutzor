<template>
  <shoutzor v-if="loaded && can('website.access')"></shoutzor>
  <login-screen v-else-if="loaded && can('website.access') === false"></login-screen>
  <load-screen v-else></load-screen>
</template>

<script>
import {mapGetters} from 'vuex';
import store from "@js/store/index";
import Shoutzor from "@js/views/Shoutzor";
import LoginScreen from "@js/components/main/login/LoginScreen";
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
        this.emitter.emit('app.ready');
    })
  }
}
</script>