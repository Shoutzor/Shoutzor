import NowPlaying from '@components/NowPlaying';

export default {
  title: 'media/NowPlaying',
  component: NowPlaying,
  argTypes: {
      media: {
          name: 'Media',
          type: { name: 'object', required: true },
          description: 'The media to show'
      },
      requestedBy: {
          name: 'Requested by',
          type: { name: 'array', required: false },
          defaultValue: 100,
          description: 'Array of users that requested the current media'
      },
  },
};

const Template = (args) => ({
  components: { NowPlaying },
  setup() {
    return { args };
  },
  template: '<now-playing v-bind="args" />',
});

import { Media } from "@models/Media";

export const Example = Template.bind({});
Example.args = {
    media: {
        ...Media,
        title: 'Ghosts \'n stuff',
        coverImage: TempCover,
        artists: [{
            id: 1,
            name: 'Deadmau5'
        }]
    },
    requestedBy: []
};
