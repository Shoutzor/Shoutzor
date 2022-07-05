<template>
    <div class="load-screen text-center">
        <img svg-inline src="@static/images/shoutzor-logo.svg" alt="Shoutz0r logo">
        <div class="center-block">
            <BaseSpinner class="mt-5"/>

            <div v-if="message.length > 0" class="mt-3">
                <p>{{ message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import "./LoadScreen.scss";
import BaseSpinner from "@components/BaseSpinner";

export default {
    name: 'LoadScreen',
    components: {BaseSpinner},
    props: {
        message: {
            type: String,
            required: false,
            default: ''
        }
    }
}
</script>
