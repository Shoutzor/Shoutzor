import BaseAlert from '@components/BaseAlert';

export default {
    title: 'base/BaseAlert',
    component: BaseAlert,
    argTypes: {
        type: {
            name: 'Type',
            type: {name: 'select', required: true},
            options: ['danger', 'warning', 'info', 'success'],
        },
        classes: {
            name: 'Style classes',
            type: {name: 'array', required: false},
            description: 'Classes for the alert'
        }
    },
};

const Template = (args) => ({
    components: {BaseAlert},
    setup() {
        return {args};
    },
    template: `<base-alert v-bind="args">${args.slot}</base-alert>`,
});

export const Error = Template.bind({});
Error.args = {
    slot: `<p><strong>Error!</strong></p><p>This is some kind of message!</p>`,
    type: 'danger'
};

export const Success = Template.bind({});
Success.args = {
    slot: `<p><strong>Success!</strong></p><p>This is some kind of message!</p>`,
    type: 'success'
};

export const Warning = Template.bind({});
Warning.args = {
    slot: `<p><strong>Warning!</strong></p><p>This is some kind of message!</p>`,
    type: 'warning'
};

export const Info = Template.bind({});
Info.args = {
    slot: `<p><strong>Info!</strong></p><p>This is some kind of message!</p>`,
    type: 'info'
};
