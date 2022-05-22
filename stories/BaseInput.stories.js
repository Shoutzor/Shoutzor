import BaseInput from '@components/BaseInput';

export default {
  title: 'base/BaseInput',
  component: BaseInput,
  argTypes: {
      onInput: {},
      type: {
          name: 'Input type',
          type: { name: 'select', required: false },
          options: ['text', 'password', 'email'],
          description: 'The type of input, note: this component is limited to text-input'
      },
      name: {
          name: 'Name',
          type: { name: 'string', required: false },
          description: 'The name of the input'
      },
      value: {
          name: 'Value',
          type: { name: 'string', required: false },
          description: 'The value of the input'
      },
      placeholder: {
          name: 'Placeholder',
          type: { name: 'string', required: false },
          description: 'The placeholder of the input'
      },
      autocomplete: {
          name: 'Autocomplete',
          type: { name: 'string', required: false },
          description: 'Tells the browser what type of field this is for autocompletion'
      },
      size: {
          name: 'Field size',
          type: { name: 'select', required: false },
          options: ['small', 'normal', 'large'],
          defaultValue: 'normal',
          description: 'The input size'
      },
      hasError: {
          name: 'Has error',
          type: { name: 'boolean', required: false },
          description: 'Indicates if an incorrect value has been entered into this field'
      },
      classes: {
          name: 'Style classes',
          type: { name: 'array', required: false },
          description: 'Classes for the alert'
      }
  },
};

const Template = (args) => ({
  components: { BaseInput },
  setup() {
    return { args };
  },
  template: `<base-input v-bind="args"></base-input>`,
});

export const Normal = Template.bind({});
Normal.args = {
    name: 'username',
    value: '',
    placeholder: 'Type your username here',
    autocomplete: 'username',
    size: 'normal',
    hasError: false
};

export const Error = Template.bind({});
Error.args = {
    name: 'username',
    value: 'some name',
    placeholder: 'Type your username here',
    autocomplete: 'username',
    size: 'normal',
    hasError: true
};
