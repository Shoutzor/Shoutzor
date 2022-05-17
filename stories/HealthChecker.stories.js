import HealthChecker from '@components/HealthChecker';

export default {
  title: 'system/HealthChecker',
  component: HealthChecker,
  argTypes: {
      onRefreshButtonClick: {},
      onRepairButtonClick: {},
      healthChecks: {
          name: 'healthChecks data',
          type: { name: 'array', required: true },
          defaultValue: [],
          description: 'The healthcheck data returned from the API'
      },
      repairResult: {
          name: 'repairResult data',
          type: { name: 'object', required: false },
          description: 'The auto-repair results returned from the API'
      },
      showHeader: {
          name: 'Show Header',
          type: { name: 'boolean', required: false },
          defaultValue: true,
          description: 'Whether to show the header and buttons'
      },
      showTitle: {
          name: 'Show Title',
          type: { name: 'boolean', required: false },
          defaultValue: true,
          description: 'Whether to show the title in the header'
      },
      headerTitle: {
          name: 'Header Title',
          type: { name: 'string', required: false },
          defaultValue: 'Health Check',
          description: 'The header title text'
      },
      showRefreshButton: {
          name: 'Show Refresh Button',
          type: { name: 'boolean', required: false },
          defaultValue: true
      },
      refreshButtonText: {
          name: 'Refresh button text',
          type: { name: 'string', required: false },
          defaultValue: 'Refresh',
          description: 'The text to show on the button (if any)'
      },
      showRepairButton: {
          name: 'Show Repair button',
          type: { name: 'boolean', required: false },
          defaultValue: true
      },
      isLoading: {
          name: 'is loading',
          type: { name: 'boolean', required: false },
          defaultValue: false,
          description: 'When true te component assumes data is loading'
      }
  },
};

const Template = (args) => ({
  components: { HealthChecker },
  setup() {
    return { args };
  },
  template: '<health-checker v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    isLoading: false,
    healthChecks: [{
        healthy: true,
        name: 'First Demo healthcheck',
        status: 'Checking if that one thing is correct'
    }, {
        healthy: false,
        name: 'Second Demo healthcheck',
        status: 'But also checking that other thing'
    }],
    repairResult: {
        result: true,
        data: [
            {
                name: 'First Demo healthcheck',
                result: 'Succeeded in fixing that issue!'
            },
            {
                name: 'Second Demo healthcheck',
                result: 'Oops, we\'re gonna need some manual help here.'
            }
        ]
    }
};
