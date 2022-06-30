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
        id: {
            type: Number,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    },
    methods: {
        onClick() {
            console.log("requested!", this.id, this.title);
        }
    }
};
</script>
