<template>
    <base-button class="btn-outline-primary btn-small request-button" @click="onClick">
        Request
    </base-button>
</template>

<script>
import BaseButton from "@components/BaseButton";

export default {
    name: 'request-button',
    components: {
        BaseButton
    },
    props: {
        media: {
            type: Object,
            required: true
        }
    },
    methods: {
        onClick() {
            console.log("requested!", this.media);
        }
    }
};
</script>
