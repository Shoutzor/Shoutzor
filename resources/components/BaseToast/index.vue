<template>
    <div :id="id" :class="classes" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <slot>Some message here</slot>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</template>

<script>
import {computed, reactive} from "vue";

export default {
    name: 'base-toast',

    props: {
        id: {
            type: String,
            required: true
        },
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
                'toast': true,
                'align-items-center': true,
                'text-white': true,
                [`bg-${props.type}`]: true,
                'border-0': true,
                'position-relative': true,
                'bottom-0': true,
                'end-0': true,
                'fade': true
            }))
        }
    }
}
</script>
