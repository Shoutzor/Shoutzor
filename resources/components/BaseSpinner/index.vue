<template>
    <div :class="classes" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</template>

<script>
import {computed, reactive} from "vue";

export default {
    name: 'base-spinner',

    props: {
        type: {
            type: String,
            required: false,
            validator: function (value) {
                return ['border', 'grow'].indexOf(value) !== -1;
            },
            default: 'border'
        },
        small: {
            type: Boolean,
            required: false,
            default: false
        },
        classes: {
            type: Array,
            required: false,
            default: []
        }
    },

    setup(props, {emit}) {
        props = reactive(props);
        return {
            classes: computed(() => ({
                'spinner-border': props.type === 'border',
                'spinner-grow': props.type === 'grow',
                'spinner-border-sm': props.small && props.type === 'border',
                'spinner-grow-sm': props.small && props.type === 'grow'
            })),
            styles: computed(() => ({}))
        }
    },
};
</script>
