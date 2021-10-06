<template>
  <shoutzor v-if="loaded && can('website.access')"></shoutzor>
  <login-screen v-else-if="loaded && can('website.access') === false"></login-screen>
  <load-screen message="Loading data, please wait" v-else></load-screen>
</template>

<script>
import {mapGetters} from 'vuex';
import store from "@js/store/index";
import Shoutzor from "@js/views/Shoutzor";
import Request from '@js/models/Request';
import Role from '@js/models/Role';
import MediaVote from '@js/models/MediaVote';
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

      //Fetch initial data
      var requestData = Request.api().fetch();
      var voteData = MediaVote.api().fetch();

    //Wait for both updates to finish loading
    Promise.all([resumeSession, updateGuestRole, requestData, voteData]).finally(() => {
        this.loaded = true;
        this.emitter.emit('app.ready');

        // Start Listening for events
        this.echo.listen('role', 'add', (payload) => Role.insert({data: payload}));
        this.echo.listen('role', 'change', (payload) => Role.insert({data: payload}));
        this.echo.listen('role', 'delete', (payload) => Role.delete(payload.id));
    })
  }
}
</script>