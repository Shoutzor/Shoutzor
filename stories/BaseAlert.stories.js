import BaseAlert from '@components/BaseAlert';

export default {
  title: 'base/BaseAlert',
  component: BaseAlert,
  argTypes: {
      classes: {
          name: 'Style classes',
          type: { name: 'array', required: false },
          description: 'Classes for the alert'
      }
  },
};

const Template = (args) => ({
  components: { BaseAlert },
  setup() {
    return { args };
  },
  template: `<base-alert v-bind="args"><template v-slot>${args.slot}</template></base-alert>`,
});

export const Error = Template.bind({});
Error.args = {
    slot: `<p><strong>Error!</strong></p><p>This is some kind of message!</p>`,
    classes: ['alert-danger']
};

export const Success = Template.bind({});
Success.args = {
    slot: `<p><strong>Success!</strong></p><p>This is some kind of message!</p>`,
    classes: ['alert-success']
};

export const Warning = Template.bind({});
Warning.args = {
    slot: `<p><strong>Warning!</strong></p><p>This is some kind of message!</p>`,
    classes: ['alert-warning']
};

export const Info = Template.bind({});
Info.args = {
    slot: `<p><strong>Info!</strong></p><p>This is some kind of message!</p>`,
    classes: ['alert-info']
};
