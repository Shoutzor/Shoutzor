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
    data() {
        return {
            modalId: null
        }
    },
    props: {
        id: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    },
    methods: {
        onClick() {
            this.requestManager.request(this.id, this.title);
        }
    }
};
</script>
