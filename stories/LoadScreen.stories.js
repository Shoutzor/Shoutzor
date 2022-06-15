import LoadScreen from '@components/LoadScreen';

export default {
    title: 'general/LoadScreen',
    component: LoadScreen,
    argTypes: {
        message: {
            name: 'Message',
            control: {type: 'String', required: false},
            description: 'The message to show while displaying the loadscreen'
        }
    },
};

const Template = (args) => ({
    components: {LoadScreen},
    setup() {
        return {args};
    },
    template: '<load-screen v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    message: 'Please wait, Let us fetch some um.. data.'
};
