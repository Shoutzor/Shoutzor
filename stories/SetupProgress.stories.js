import SetupProgress from '@components/SetupProgress';

export default {
  title: 'system/SetupProgress',
  component: SetupProgress,
  argTypes: {
      setupSteps: {
          name: 'Setup Steps',
          type: { name: 'array', required: true },
          description: 'The setup steps to show and their status'
      },
      isLoading: {
          name: 'Is loading',
          type: { name: 'boolean', required: false },
          description: 'Whether setup steps are being fetched'
      }
  },
};

const Template = (args) => ({
  components: { SetupProgress },
  setup() {
    return { args };
  },
  template: '<setup-progress v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    isLoading: false,
    setupSteps: [
        {
            isLoading: false,
            name: 'Copying files',
            description: 'Copy the installation files',
            status: 1
        },
        {
            isLoading: false,
            name: 'Copying files',
            description: 'Copy the installation files',
            status: 0,
            error: 'Failed to copy files: Not enough disk space'
        },
        {
            isLoading: true,
            name: 'Copying files',
            description: 'Copy the installation files',
            status: -1
        },{
            isLoading: false,
            name: 'Copying files',
            description: 'Copy the installation files',
            status: -1
        }
    ]
};
