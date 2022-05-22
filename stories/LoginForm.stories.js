import LoginForm from '@components/LoginForm';

export default {
  title: 'general/LoginForm',
  component: LoginForm,
  argTypes: {
      username: {
          name: 'Name',
          type: { name: 'string', required: false },
          description: 'The name of the input'
      },
  },
};

const Template = (args) => ({
  components: { LoginForm },
  setup() {
    return { args };
  },
  template: '<login-form v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {};
