import StatusIcon from '@components/StatusIcon';

export default {
  title: 'general/StatusIcon',
  component: StatusIcon,
  argTypes: {
      iconName: {
          name: 'Icon Name',
          control: { type: 'array', required: true },
          description: 'The name of the icon to display'
      },
      classes: {
          name: 'Classes',
          control: { type: 'array', required: true },
          description: 'Any classes to add to the component'
      },
      iconClasses: {
          name: 'Icon Classes',
          control: { type: 'array', required: true },
          description: 'Any classes to add to the icon child-component'
      }
  },
};

const Template = (args) => ({
  components: { StatusIcon },
  setup() {
    return { args };
  },
  template: '<status-icon v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    iconName: 'b-icon-check2',
    classes: ['text-white', 'bg-success'],
    iconClasses: []
};
