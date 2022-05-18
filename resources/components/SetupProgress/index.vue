<template>
    <div>
        <div v-if="isLoading" class="card card-sm">
            <div class="card-body">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>

        <template v-else-if="setupSteps">
            <setup-step
                v-for="step in setupSteps"
                v-bind:key="step.name"
                v-bind="step">
            </setup-step>
        </template>

        <div v-else class="card card-sm">
            <div class="card-body">
                Could not load the installation steps
            </div>
        </div>
    </div>
</template>

<script>
import SetupStep from "@components/SetupStep";

export default {
    name: "setup-progress",

    components: {
        SetupStep
    },

    props: {
        setupSteps: {
            type: Array,
            required: false,
            default: []
        },
        isLoading: {
            type: Boolean,
            required: false,
            default: false
        }
    }
}
</script>
