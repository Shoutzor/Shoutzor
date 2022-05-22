<template>
    <input
        :type="type"
        :name="name"
        :value="value"
        :placeholder="placeholder"
        :class="classes"
        :autocomplete="autocomplete"
        @input="handleInput"
        :aria-label="name" />
</template>

<script>
import {computed, reactive} from "vue";

export default {
    name: 'base-input',

    props: {
        type: {
            type: String,
            required: false,
            default: 'text',
            validator: function (value) {
                return ['text', 'password', 'email'].indexOf(value) !== -1;
            }
        },
        name: {
            type: String,
            required: false
        },
        value: {
            type: String,
            required: false
        },
        placeholder: {
            type: String,
            required: false
        },
        autocomplete: {
            type: String,
            required: false
        },
        size: {
            type: String,
            required: false,
            default: 'normal',
            validator: function (value) {
                return ['small', 'normal', 'large'].indexOf(value) !== -1;
            }
        },
        hasError: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    emits: ['input'],

    data () {
        return {
            content: this.value
        }
    },

    methods: {
        handleInput (e) {
            this.$emit('input', this.content)
        }
    },

    setup(props, { emit }) {
        props = reactive(props);

        return {
            classes: computed(() => ({
                'form-control': true,
                'form-control-sm': props.size === 'small',
                'form-control-lg': props.size === 'large',
                'is-invalid': props.hasError
            }))
        }
    }
}
</script>
