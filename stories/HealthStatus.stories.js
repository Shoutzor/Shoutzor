import HealthStatus from '@components/HealthStatus';

export default {
  title: 'system/HealthStatus',
  component: HealthStatus,
  argTypes: {
      healthy: {
          name: 'Healthy',
          type: { name: 'boolean', required: true },
          defaultValue: 0,
          description: 'Whether the health-check is healthy or not'
      },
      name: {
          name: 'Name',
          type: { name: 'string', required: true },
          defaultValue: 100,
          description: 'The name of the health-check'
      },
      status: {
          name: 'Status',
          type: { name: 'string', required: false },
          defaultValue: 0,
          description: 'The status of the health-check, used to provide feedback to the user'
      }
  },
};

const Template = (args) => ({
  components: { HealthStatus },
  setup() {
    return { args };
  },
  template: '<health-status v-bind="args" />',
});

export const Success = Template.bind({});
Success.args = {
    healthy: true,
    name: 'Demo Status',
    status: 'Systems are reporting a win in this sector, sir.'
};

export const Failure = Template.bind({});
Failure.args = {
    healthy: false,
    name: 'Demo Status',
    status: 'Sir, the user does not seem impressed.'
};
