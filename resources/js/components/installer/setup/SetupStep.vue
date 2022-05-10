<template>
    <div class="card card-sm rounded-0">
        <div class="card-body d-flex">
            <StatusIcon
                v-if="status === 1"
                classes="bg-green-lt text-white"
                iconName="b-icon-check2"></StatusIcon>
            <StatusIcon
                v-else-if="status === 0"
                classes="bg-red-lt text-white"
                iconName="b-icon-exclamation-circle"></StatusIcon>
            <StatusIcon
                v-else-if="running === true"
                classes="bg-azure text-white"
                iconClasses="rotate"
                iconName="b-icon-gear"></StatusIcon>
            <StatusIcon
                v-else
                classes="bg-azure text-white"
                iconName="b-icon-clock"></StatusIcon>

            <div class="ms-3 w-100">
                <div class="strong">{{ name }}</div>
                <div class="pre-text">{{ description }}</div>

                <div v-if="status === 0" class="alert alert-danger mt-1 w-100">
                    <strong>An error occured:</strong>
                    <br />
                    {{ error }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StatusIcon from "@js/components/global/status/StatusIcon";

export default {
    name: "setup-step",

    components: {
        StatusIcon
    },

    props: {
        name: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: false,
            default: ''
        },
        status: {
            type: Number,
            required: false,
            default: -1
        },
        running: {
            type: Boolean,
            required: false,
            default: false
        },
        error: {
            type: String,
            required: false,
            default: ''
        }
    }
}
</script>

<style lang="scss">
.pre-text {
    white-space: pre-wrap;
}

.rotate {
    -webkit-animation: 2.0s linear infinite spinner-border;
    animation: 2.0s linear infinite spinner-border;
}
</style>
