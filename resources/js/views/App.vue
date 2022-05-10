<template>
  <shoutzor v-if="loaded && can('website.access')"></shoutzor>
  <login-screen v-else-if="loaded && can('website.access') === false"></login-screen>
  <load-screen message="Loading data, please wait" v-else></load-screen>
</template>

<script>
import {mapGetters} from 'vuex';
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
    can: 'can'
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
    this.emitter.on('app.ready', () => {
        this.loaded = true;
    })
  }
}
</script>