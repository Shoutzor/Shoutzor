<template>
    <button :class="classes" :disabled="disabled" class="btn" @click="onClick">
        <slot></slot>
    </button>
</template>

<script>
import {computed, reactive} from "vue";

export default {
    name: 'base-button',

    props: {
        classes: {
            type: Array,
            required: false,
            default: []
        },
        disabled: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    emits: ['click'],

    setup(props, { emit }) {
        props = reactive(props);

        return {
            onClick() {
                emit('click');
            },
            styles: computed(() => ({
                'pointer-events': props.disabled ? 'none' : 'auto'
            }))
        }
    }
};
</script>
