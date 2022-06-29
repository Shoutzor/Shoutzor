<template>
    <span :class="classes">
        <component :is="icon" class="mediasource-icon" />
    </span>
</template>

<script>
import 'bootstrap-icons-vue';
import {computed, reactive} from "vue";

export default {
    name: 'media-icon',
    props: {
        is_video: {
            Type: Boolean,
            required: true
        }
    },
    setup(props) {
        props = reactive(props);

        return {
            classes: computed(() => ({
                'avatar': true,
                'mediatype': true,
                'text-white': true,
                'bg-video': props.is_video,
                'video': props.is_video,
                'bg-audio': !props.is_video,
                'audio': !props.is_video
            })),
            icon: computed(() => {
                return props.is_video ? 'b-icon-film' : 'b-icon-music-note-beamed';
            })
        };
    }
}
</script>
