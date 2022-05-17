import BeautifiedTime from '@components/BeautifiedTime';

export default {
  title: 'general/BeautifiedTime',
  component: BeautifiedTime,
  argTypes: {
      seconds: {
          name: 'Seconds',
          control: { type: 'number', required: true },
          description: 'The time in seconds'
      }
  },
};

const Template = (args) => ({
  components: { BeautifiedTime },
  setup() {
    return { args };
  },
  template: '<beautified-time v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    seconds: 13370
};
