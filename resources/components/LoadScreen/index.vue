<template>
    <div class="load-screen text-center">
        <img src="@static/images/shoutzor-logo-small.png" alt="Shoutz0r logo">
        <div class="center-block">
            <div class="spinner-border mt-5" role="status"></div>
            <div v-if="message.length > 0" class="mt-3">
                <p>{{ message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import "./LoadScreen.css";

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
