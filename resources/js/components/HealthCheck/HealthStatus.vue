<template>
    <div class="card card-sm">
        <div class="card-body d-flex">
            <span
                v-if="healthy === true"
                class="avatar healthStatus bg-green-lt">
                <check-icon class="healthStatus-icon"></check-icon>
            </span>
            <span
                v-else
                class="avatar healthStatus bg-red-lt">
                <alert-circle-icon class="healthStatus-icon"></alert-circle-icon>
            </span>

            <div class="ms-3">
                <div class="strong">{{ name }}</div>
                <div class="pre-text">{{ status }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
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
