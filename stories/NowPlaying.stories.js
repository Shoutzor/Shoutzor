import NowPlaying from '@components/NowPlaying';

export default {
    title: 'media/NowPlaying',
    component: NowPlaying
};

const Template = (args) => ({
    components: {NowPlaying},
    setup() {
        return {args};
    },
    template: '<now-playing />',
});

export const Example = Template.bind({});
