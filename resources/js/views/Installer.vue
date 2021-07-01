<template>
  <div id="installer_wrapper">
    <div class="page">
      <div class="container-tight py-4">
        <div class="text-center mb-4">
          <img alt="Shoutz0r logo" src="@static/images/shoutzor-logo-large.png" class="logo">
        </div>

        <router-view
          :showNextButton="updateShowNextButton"
          :showCustomButton="updateShowCustomButton"
          :updateButtonText="updateButtonText"
          :updateButtonLoading="updateButtonLoading"></router-view>

        <div class="row align-items-center mt-3">
          <div class="col-4">
            <div class="progress">
              <div aria-valuemax="100"
                   aria-valuemin="0"
                   v-bind:aria-valuenow="progress"
                   class="progress-bar"
                   role="progressbar"
                   :style="{width: `${progress}%`}">
                <span class="visually-hidden">{{ progress }}% Complete</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="btn-list justify-content-end">
              <router-link v-if="showButton && next !== null" :to="{ name: next }" class="btn btn-primary">
                Next Step
              </router-link>
              <button
                  v-else-if="showButton === false && showCustomButton === true"
                  v-on:click="buttonClickProxy"
                  :class="(buttonIsLoading ? 'btn-loading' : '') + ' btn btn-primary'">
                {{ buttonText }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default {
  name: "Installer",

  data() {
    return {
      showButton: true,
      showCustomButton: true,
      buttonIsLoading: false,
      buttonText: ''
    }
  },

  watch: {
    //This makes sure that if a custom button is hidden, this wont stay this way.
    //ie: every route will work with the same default values.
    $route(to, from) {
      this.resetButtonValues();
    }
  },

  computed: {
    progress: function() {
      let routes = this.$router.options.routes;
      let currentItem = routes.map(e => e.name).indexOf(this.$route.name);
      if(currentItem > 0) {
        return Math.round((100 / (routes.length - 1)) * currentItem);
      } else {
        return 0;
      }
    },

    next: function() {
      let routes = this.$router.options.routes;
      let currentItem = routes.map(e => e.name).indexOf(this.$route.name);

      if(routes.length > currentItem + 1) {
        return routes[currentItem + 1].name;
      }
      else {
        return null;
      }
    }
  },

  methods: {
    resetButtonValues() {
      this.showButton = true;
      this.showCustomButton = true;
      this.buttonText = 'Next step';
      this.buttonIsLoading = false;
    },

    updateShowNextButton(show) {
      this.showButton = show;
    },

    updateShowCustomButton(show) {
      this.showCustomButton = show;
    },

    updateButtonLoading(isLoading) {
      this.buttonIsLoading = isLoading;
    },

    updateButtonText(text) {
      this.buttonText = text;
    },

    // This method just emits an event so child-views can trigger their onClick listener
    buttonClickProxy() {
      Vue.bus.emit('buttonClicked');
    }
  }
}
</script>
