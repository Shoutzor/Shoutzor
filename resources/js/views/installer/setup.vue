<template>
    <div class="card card-md">
        <div class="card-body bg-white text-center py-4 p-sm-4">
            <h1 class="text-gray-dark">Setup</h1>
            <p class="text-muted">Please wait while the installer finishes the installation of Shoutz0r</p>
        </div>

        <div class="hr-text hr-text-center hr-text-spaceless">progress</div>

        <setup-progress
            id="setupprogress"
            ref="setupprogress"
            :installStateUpdate="onInstallStateUpdate"
            class="mt-3"
        ></setup-progress>
    </div>
</template>

<script>
import SetupProgress from "@js/components/installer/setup/SetupProgress";

export default {
    name: "installer-healthcheck-view",

    components: {
        SetupProgress
    },

    props: {
        showNextButton: {type: Function},
        showCustomButton: {type: Function},
        updateButtonText: {type: Function}
    },

    created() {
        this.emitter.on('buttonClicked', this.onButtonClick);
    },

    mounted() {
        this.showNextButton(false);
        this.showCustomButton(false);
        this.updateButtonText('Retry');
    },

    methods: {
        onButtonClick() {
            this.emitter.emit('setup.retry');
        },

        onInstallStateUpdate(isActive, isInstalled) {
            this.showNextButton(false);
            this.showCustomButton(false);

            if(!isInstalled && !isActive) {
                this.showCustomButton(true);
            }
            else {
                if(isInstalled) {
                    console.log("showing Next button");
                    this.showNextButton(true);
                }
            }
        }
    }
};
</script>

<style lang="scss">
#healthcheck {
    padding: 5px;
    margin-top: 5px;
}
</style>
