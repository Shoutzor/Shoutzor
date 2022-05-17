<template>
    <div class="playbutton" @click="onClick">
        <b-icon-play-fill v-if="state === 'stopped'" class="play"></b-icon-play-fill>
        <b-icon-stop-fill v-if="state === 'playing'" class="stop"></b-icon-stop-fill>

        <div v-if="state === 'loading'" class="spinner-border loading" role="status"></div>
    </div>
</template>

<script>
import './PlayButton.scss'
import { BIconPlayFill, BIconStopFill } from 'bootstrap-icons-vue';
import { reactive } from 'vue';

export default {
    name: 'play-button',
    components: { BIconPlayFill, BIconStopFill },
    props: {
        state: {
            type: String,
            required: true,
            validator: function (value) {
                return ['stopped', 'playing', 'loading'].indexOf(value) !== -1;
            },
            default: 'stopped'
        }
    },

    emits: ['click'],

    setup(props, { emit }) {
        props = reactive(props);
        return {
            onClick() {
                emit('click');
            }
        }
    }
};
</script>
