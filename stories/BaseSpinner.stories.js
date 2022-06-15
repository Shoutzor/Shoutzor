import BaseSpinner from '@components/BaseSpinner';

export default {
    title: 'base/BaseSpinner',
    component: BaseSpinner,
    argTypes: {
        type: {
            name: 'Animation Type',
            control: {type: 'select', required: true},
            options: ['border', 'grow'],
            defaultValue: 'border',
            description: 'The type of animation the spinner should use'
        },
        small: {
            name: 'Small',
            type: {name: 'boolean', required: false},
            description: 'Whether to make the spinner small or not'
        }
    },
};

const Template = (args) => ({
    components: {BaseSpinner},
    setup() {
        return {args};
    },
    template: `<base-spinner v-bind="args"></base-spinner>`,
});

export const Border = Template.bind({});
Border.args = {
    type: 'border',
    small: false
};

export const Grow = Template.bind({});
Grow.args = {
    type: 'grow',
    small: false
};

