import BaseProgressbar from '@components/BaseProgressbar';

export default {
  title: 'base/BaseProgressbar',
  component: BaseProgressbar,
  argTypes: {
      minValue: {
          name: 'Min value',
          type: { name: 'number', required: false },
          defaultValue: 0,
          description: 'The minimum value of the progressbar'
      },
      maxValue: {
          name: 'Max value',
          type: { name: 'number', required: false },
          defaultValue: 100,
          description: 'The maximum value of the progressbar'
      },
      currentValue: {
          name: 'Current value',
          type: { name: 'number', required: true },
          defaultValue: 0,
          description: 'The current value of the progressbar'
      },
      preText: {
          name: 'Pre text',
          type: { name: 'string', required: false },
          defaultValue: '',
          description: 'The text to show before the progressbar'
      },
      postText: {
          name: 'Post text',
          type: { name: 'string', required: false },
          defaultValue: '',
          description: 'The text to show after the progressbar'
      },
      isStriped: {
          name: 'Striped progressbar',
          type: { name: 'boolean', required: false },
          defaultValue: false,
          description: 'Whether to make the progressbar striped or not'
      },
      isAnimated: {
          name: 'Animated progressbar',
          type: { name: 'boolean', required: false },
          defaultValue: false,
          description: 'Whether to make the progressbar striped animated or not'
      }
  },
};

const Template = (args) => ({
  components: { BaseProgressbar },
  setup() {
    return { args };
  },
  template: '<base-progressbar v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = {
    minValue: 0,
    maxValue: 100,
    currentValue: 42,
    preText: "text before",
    postText: "text after"
};

export const Striped = Template.bind({});
Striped.args = {
    minValue: 0,
    maxValue: 100,
    currentValue: 42,
    preText: "text before",
    postText: "text after",
    isStriped: true
};

export const Animated = Template.bind({});
Animated.args = {
    minValue: 0,
    maxValue: 100,
    currentValue: 42,
    preText: "text before",
    postText: "text after",
    isStriped: true,
    isAnimated: true
};
