<template>
    <div>
        <div v-if="loading" class="card card-sm">
            <div class="card-body">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>

        <setup-step
            v-for="step in installSteps"
            v-else-if="installSteps && installSteps.length > 0"
            v-bind:key="step.name"
            v-bind="step">
        </setup-step>

        <div v-else class="card card-sm">
            <div class="card-body">
                Could not load the installation steps
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import SetupStep from "@js/components/installer/setup/SetupStep";

export default {
    name: "setup-progress",

    components: {
        SetupStep
    },

    props: {
        installStateUpdate: {
            type: Function,
            required: false,
            default: (isActive, isInstalled) => {
            }
        }
    },

    data() {
        return {
            installSteps: [],
            loading: true,
            errored: false,
            active: false
        };
    },

    created() {
        this.emitter.on('setup.retry', this.onRetryButtonClick);
    },

    mounted() {
        this.tryInstallation();
    },

    methods: {
        resetVariables() {
            this.installSteps = [];
            this.loading = true;
            this.errored = false;
        },

        onRetryButtonClick() {
            if(this.active === false) {
                this.tryInstallation();
            }
        },

        async tryInstallation() {
            this.active = true;

            this.resetVariables();
            this.installStateUpdate(true, false);

            // Get the installation steps
            await this.getInstallationSteps();
            this.loading = false;

            // Iterate over all install steps
            for(let i = 0; i < this.installSteps.length; i++) {
                let step = this.installSteps[i];

                // Mark step as active
                step.running = true;

                await this.runStep(step);

                // Mark step as finished
                step.running = false;

                // Check for errors
                if(this.errored === true || step.status === 0) {
                    this.installStateUpdate(false, false);
                    this.active = false;
                    break;
                }
            }

            this.installStateUpdate(false, true);
            this.active = false;
        },

        getInstallationSteps() {
            return axios.get('/installer/setup')
                        .then(response => {
                            this.installSteps = response.data;
                        })
                        .catch(err => {
                            this.errored = true;

                            //Install failed
                            this.installStateUpdate(false, false);
                        });
        },

        runStep(step) {
            return axios.get('/installer/setup/' + step.slug)
                        .then(response => {
                            step.status = response.data.status;
                            step.error = response.data.error;
                        })
                        .catch(err => {
                            this.errored = true;

                            //Install failed
                            this.installStateUpdate(false, false);
                        });
        }
    }
}
</script>