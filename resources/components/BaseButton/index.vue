<template>
    <button
        :class="classes"
        :disabled="disabled"
        :style="styles"
        @click="onClick">
        <slot></slot>
    </button>
</template>

<script>
import {computed, reactive} from "vue";

export default {
    name: 'base-button',

    props: {
        disabled: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    emits: ['click'],

    setup(props, {emit}) {
        props = reactive(props);

        return {
            onClick() {
                emit('click');
            },
            classes: computed(() => ({
                'btn': true
            })),
            styles: computed(() => ({
                'pointer-events': props.disabled ? 'none' : 'auto'
            }))
        }
    }
};
</script>
