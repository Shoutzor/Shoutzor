<template>
    <main>
        <div id="installer_wrapper">
            <div class="page">
                <div class="py-4">
                    <div class="text-center mb-4">
                        <img alt="Shoutz0r logo" class="logo filter-invert" src="@static/images/shoutzor-logo-large.png">
                    </div>

                    <router-view
                        :showCustomButton="updateShowCustomButton"
                        :showNextButton="updateShowNextButton"
                        :updateButtonLoading="updateButtonLoading"
                        :updateButtonText="updateButtonText"></router-view>

                    <div class="row align-items-center mt-3">
                        <div class="col-4">
                            <div class="progress">
                                <div :style="{width: `${progress}%`}"
                                     aria-valuemax="100"
                                     aria-valuemin="0"
                                     class="progress-bar"
                                     role="progressbar"
                                     v-bind:aria-valuenow="progress">
                                    <span class="visually-hidden">{{ progress }}% Complete</span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <router-link v-if="showButton && next !== null" :to="{ name: next }" class="btn btn-primary text-white">
                                    Next Step
                                </router-link>
                                <button
                                    v-else-if="showButton === false && showCustomButton === true"
                                    class = "btn btn-primary text-white"
                                    :class="(buttonIsLoading ? 'btn-loading' : '')"
                                    v-on:click="buttonClickProxy">
                                    {{ buttonText }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
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
            }
            else {
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
            this.emitter.emit('buttonClicked');
        }
    }
}
</script>
