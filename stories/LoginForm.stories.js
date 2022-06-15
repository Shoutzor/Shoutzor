import LoginForm from '@components/LoginForm';

export default {
    title: 'general/LoginForm',
    component: LoginForm,
    argTypes: {
        onLogin: {},
        remember_me: {
            name: 'Remember Me',
            type: {name: 'boolean', required: false},
            description: 'Whether Remember me is checked or not'
        },
        loading: {
            name: 'Loading',
            type: {name: 'boolean', required: false},
            description: 'Whether a login request is loading'
        },
        error: {
            name: 'Error',
            type: {name: 'object', required: false},
            description: 'An error to display to the user (authentication failure feedback)'
        },
        fieldError: {
            name: 'Field Errors',
            type: {name: 'array', required: false},
            description: 'Which inputs should be marked as errored'
        }
    },
};

const Template = (args) => ({
    components: {LoginForm},
    setup() {
        return {args};
    },
    template: '<login-form v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    remember_me: false,
    loading: false,
    error: {type: "danger", message: "login failed! No username provided"},
    fieldError: ["username"]
};
