import MediaPlayer from '@components/MediaPlayer';

export default {
    title: 'media/MediaPlayer',
    component: MediaPlayer,
    argTypes: {
        onMediaplayerPlay: {},
        onMediaplayerUpvote: {},
        onMediaplayerDownvote: {},
        onMediaplayerVideo: {},
        currentMedia: {
            name: 'Current Media',
            type: {name: 'object', required: true},
            description: 'The media that is currently played by shoutzor'
        },
        requestedBy: {
            name: 'Requested by',
            type: {name: 'array', required: false},
            defaultValue: 100,
            description: 'Array of users that requested the current media'
        },
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
        isAuthenticated: {
            name: 'Is authenticated',
            type: {name: 'boolean', required: false},
            description: 'If the user is authenticated'
        },
        videoEnabled: {
            name: 'Video Enabled',
            type: {name: 'boolean', required: false},
            description: 'If the stream supports video'
        }
    },
};

const Template = (args) => ({
    components: {MediaPlayer},
    setup() {
        return {args};
    },
    template: '<media-player v-bind="args" />',
});

import TempCover from '@static/images/album_temp.jpg';

export const Example = Template.bind({});
Example.args = {
    currentMedia: {
        title: 'Ghosts \'n stuff',
        coverImage: TempCover,
        artists: [{
            id: 1,
            name: 'Deadmau5'
        }],
        timePassed: '0:35', //Should be converted from seconds provided by API
        timeRemaining: '2:41', // Should be converted from seconds provided by API
        percentagePlayed: 42
    },
    playerStatus: 'stopped',
    volume: 100,
    requestedBy: [],
    isAuthenticated: true,
    videoEnabled: false
};
