<template>
    <div id="app-loader">
        <img src="@static/images/shoutzor-logo-large.png" alt="Shoutz0r logo">
        <div class="spinner-border mt-5 text-gray" role="status"></div>
        <div v-if="message.length > 0" class="text-center mt-5">
            <p>{{ message }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoadScreen',
    props: {
        message: {
            type: String,
            required: false,
            default: ''
        }
    }
}
</script>

<style lang="scss" scoped>
#app-loader {
    opacity: 1 !important;
    z-index: 99999 !important;
}
</style>
