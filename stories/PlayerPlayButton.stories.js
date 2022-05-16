import PlayButton from '@components/PlayButton';

export default {
  title: 'player/PlayButton',
  component: PlayButton,
  argTypes: {
      onClick: {},
      state: {
          name: 'Button state',
          control: { type: 'select', required: true },
          options: ['stopped', 'playing', 'loading'],
          defaultValue: 'stopped',
          description: 'The state of the playbutton'
      }
  },
};

const Template = (args) => ({
  components: { PlayButton },
  setup() {
    return { args };
  },
  template: '<play-button v-bind="args" />',
});

export const Loading = Template.bind({});
Loading.args = {
    state: 'loading'
};

export const Playing = Template.bind({});
Playing.args = {
    state: 'playing'
};

export const Stopped = Template.bind({});
Stopped.args = {
    state: 'stopped'
};
