<template>
    <div class="card card-sm">
        <div class="card-body d-flex">
            <StatusIcon
                v-if="healthy === true"
                classes="bg-green-lt"
                iconName="b-icon-check2"></StatusIcon>
            <StatusIcon
                v-else
                classes="bg-red-lt"
                iconName="b-icon-exclamation-circle"></StatusIcon>

            <div class="ms-3 w-100">
                <div class="strong">{{ name }}</div>
                <div class="pre-text">{{ status }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import StatusIcon from "@js/components/global/status/StatusIcon";

export default {
    components: {StatusIcon},
    props: {
        healthy: {
            type: Boolean,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        status: {
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
</style>
