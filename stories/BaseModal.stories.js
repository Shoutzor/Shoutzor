import BaseModal from '@components/BaseModal';

export default {
  title: 'base/BaseModal',
  component: BaseModal,
  argTypes: {
      onCancelClick: {},
      onConfirmClick: {},
      id: {
          name: 'Unique Modal ID',
          type: { name: 'string', required: true },
          description: 'The unique ID for this modal'
      },
      title: {
          name: 'Modal Title',
          type: { name: 'string', required: false },
          description: 'The title to show in the header of the modal'
      },
      cancelButton: {
          name: 'Cancel button',
          type: { name: 'string', required: false },
          description: 'What the cancel button should say'
      },
      confirmButton: {
          name: 'Confirm button',
          type: { name: 'string', required: false },
          description: 'What the confirm button should say'
      },
      show: {
          name: 'Show Modal',
          type: { name: 'boolean', required: false },
          description: 'If the model should be shown'
      },
      hasHeader: {
          name: 'Has Header',
          type: { name: 'boolean', required: false },
          description: 'If the model should show a header'
      },
      hasFooter: {
          name: 'Has Footer',
          type: { name: 'boolean', required: false },
          description: 'If the model should show a footer'
      },
      hasCancelButton: {
          name: 'Has Cancel Button',
          type: { name: 'boolean', required: false },
          description: 'If the model should show a cancel button'
      },
      hasConfirmButton: {
          name: 'Has Confirm Button',
          type: { name: 'boolean', required: false },
          description: 'If the model should show a confirm button'
      }
  },
};

const Template = (args) => ({
  components: { BaseModal },
  setup() {
    return {
        args
    };
  },
  template: `
      <base-modal v-bind="args">${args.slot}</base-modal>
  `,
});

export const Example = Template.bind({});
Example.args = {
    id: "exampleModal",
    title: "Example modal",
    slot: `<p>You can put your modal body here</p>`,
    show: true
};

