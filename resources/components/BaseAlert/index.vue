<template>
    <div :class="classes" role="alert">
        <slot></slot>
    </div>
</template>

<script>
import {computed, reactive} from "vue";

export default {
    name: 'base-alert',

    props: {
        type: {
            type: String,
            required: true,
            validator: function (value) {
                return ['danger', 'warning', 'info', 'success'].indexOf(value) !== -1;
            },
            default: 'info'
        }
    },

    setup(props) {
        props = reactive(props);

        return {
            classes: computed(() => ({
                'alert': true,
                [`alert-${props.type}`]: true
            }))
        }
    }
};
</script>
