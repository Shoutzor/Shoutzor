import TheMediaplayer from '@components/TheMediaplayer';

export default {
    title: 'media/TheMediaplayer',
    component: TheMediaplayer,
    argTypes: {
        onMediaplayerPlay: {},
        onMediaplayerUpvote: {},
        onMediaplayerDownvote: {},
        onMediaplayerVideo: {},
        volume: {
            name: 'Volume',
            type: {name: 'number', required: true},
            description: 'The player volume'
        },
        playerStatus: {
            name: 'Player status',
            type: {name: 'string', required: true},
            description: 'The player status'
        },
        videoEnabled: {
            name: 'Video Enabled',
            type: {name: 'boolean', required: false},
            description: 'If the stream supports video'
        }
    },
};

const Template = (args) => ({
    components: {TheMediaplayer},
    setup() {
        return {args};
    },
    template: '<the-mediaplayer v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    playerStatus: 'stopped',
    volume: 100,
    videoEnabled: false
};
