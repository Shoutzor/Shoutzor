<template>
    <div class="base-progressbar">
        <span v-if="preText">{{ preText }}</span>
        <div class="progress">
            <div
                role="progressbar"
                :aria-valuemin="minValue"
                :aria-valuemax="maxValue"
                :aria-valuenow="currentValue"
                :class="classes"
                :style="styles"></div>
        </div>
        <span v-if="postText">{{ postText }}</span>
    </div>
</template>

<script>
import './BaseProgressbar.css'
import { reactive, computed } from 'vue';

export default {
    name: 'base-progressbar',

    props: {
        preText: {
            type: String,
            required: false,
            default: ''
        },
        postText: {
            type: String,
            required: false,
            default: ''
        },
        minValue: {
            type: Number,
            required: false,
            default: 0
        },
        maxValue: {
            type: Number,
            required: false,
            default: 100
        },
        currentValue: {
            type: Number,
            required: true,
            default: 0
        },
        isStriped: {
            type: Boolean,
            required: false,
            default: false
        },
        isAnimated: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    setup(props, { emit }) {
        props = reactive(props);
        return {
            classes: computed(() => ({
                'progress-bar': true,
                'progress-bar-striped': props.isStriped,
                'progress-bar-animated': props.isAnimated
            })),
            styles: computed(() => ({
                'width': props.currentValue + '%'
            }))
        }
    },
};
</script>
