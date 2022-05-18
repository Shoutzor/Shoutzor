import SetupStep from '@components/SetupStep';

export default {
  title: 'system/SetupStep',
  component: SetupStep,
  argTypes: {
      name: {
          name: 'Name',
          type: { name: 'string', required: true },
          description: 'The name of the health-check'
      },
      description: {
          name: 'Description',
          type: { name: 'string', required: true },
          description: 'A basic description of the setup step'
      },
      status: {
          name: 'Status',
          type: { name: 'number', required: false },
          description: 'The status of the health-check, used to provide feedback to the user'
      },
      isLoading: {
          name: 'Is loading',
          type: { name: 'boolean', required: false },
          description: 'Whether the step is being executed, waiting for the result'
      },
      error: {
          name: 'Error message',
          type: { name: 'string', required: false },
          description: 'Used to provide feedback to the user of any errors that occured during this setup step'
      }
  },
};

const Template = (args) => ({
  components: { SetupStep },
  setup() {
    return { args };
  },
  template: '<setup-step v-bind="args" />',
});

export const Success = Template.bind({});
Success.args = {
    isLoading: false,
    name: 'Copying files',
    description: 'Copy the installation files',
    status: 1
};

export const Failure = Template.bind({});
Failure.args = {
    isLoading: false,
    name: 'Copying files',
    description: 'Copy the installation files',
    status: 0,
    error: 'Failed to copy files: Not enough disk space'
};

export const Executing = Template.bind({});
Executing.args = {
    isLoading: true,
    name: 'Copying files',
    description: 'Copy the installation files',
    status: -1
};

export const Pending = Template.bind({});
Pending.args = {
    isLoading: false,
    name: 'Copying files',
    description: 'Copy the installation files',
    status: -1
};
