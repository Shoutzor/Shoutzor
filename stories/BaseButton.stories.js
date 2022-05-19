import BaseButton from '@components/BaseButton';

export default {
  title: 'base/BaseButton',
  component: BaseButton,
  argTypes: {
      onClick: {},
      classes: {
          name: 'Style classes',
          type: { name: 'array', required: false },
          description: 'Classes for the alert'
      }
  },
};

const Template = (args) => ({
  components: { BaseButton },
  setup() {
    return { args };
  },
  template: `<base-button v-bind="args"><template v-slot>${args.slot}</template></base-button>`,
});

export const Normal = Template.bind({});
Normal.args = {
    slot: `Click me`,
    classes: ['btn-primary']
};

export const Disabled = Template.bind({});
Disabled.args = {
    slot: `You can't click me`,
    classes: ['btn-primary'],
    disabled: true
};

