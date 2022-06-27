<template>
    <div class="playbutton" @click="onClick">
        <b-icon-play-fill v-if="state === PlayerState.STOPPED" class="play"></b-icon-play-fill>
        <b-icon-stop-fill v-else-if="state === PlayerState.PLAYING" class="stop"></b-icon-stop-fill>
        <div v-else class="spinner-border loading" role="status"></div>
    </div>
</template>

<script>
import './PlayButton.scss'
import {BIconPlayFill, BIconStopFill} from 'bootstrap-icons-vue';
import {PlayerState} from "@models/PlayerState";

export default {
    name: 'play-button',
    components: {BIconPlayFill, BIconStopFill},
    data() {
        return {
            PlayerState
        }
    },
    props: {
        state: {
            type: Number,
            required: true,
            validator: function (value) {
                return Object.values(PlayerState).indexOf(value) !== -1;
            },
            default: PlayerState.STOPPED
        }
    },

    emits: ['click'],

    setup(_props, {emit}) {
        return {
            onClick() {
                emit('click');
            }
        }
    }
};
</script>
