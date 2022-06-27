import NowPlaying from '@components/NowPlaying';

export default {
    title: 'media/NowPlaying',
    component: NowPlaying
};

const Template = (_args) => ({
    components: {NowPlaying},
    template: '<now-playing />',
});

export const Example = Template.bind({});
