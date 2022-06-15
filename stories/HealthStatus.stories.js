import HealthStatus from '@components/HealthStatus';

export default {
    title: 'system/HealthStatus',
    component: HealthStatus,
    argTypes: {
        healthy: {
            name: 'Healthy',
            type: {name: 'boolean', required: true},
            description: 'Whether the health-check is healthy or not'
        },
        name: {
            name: 'Name',
            type: {name: 'string', required: true},
            description: 'The name of the health-check'
        },
        description: {
            name: 'Description',
            type: {name: 'string', required: false},
            description: 'A basic description of the health-check'
        }
    },
};

const Template = (args) => ({
    components: {HealthStatus},
    setup() {
        return {args};
    },
    template: '<health-status v-bind="args" />',
});

export const Success = Template.bind({});
Success.args = {
    healthy: true,
    name: 'Disk Status',
    description: 'Checks for read/write errors'
};

export const Failure = Template.bind({});
Failure.args = {
    healthy: false,
    name: 'Demo Status',
    description: 'Checks for read/write errors'
};
