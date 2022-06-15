import UserList from '@components/UserList';

export default {
    title: 'general/UserList',
    component: UserList,
    argTypes: {
        users: {
            name: 'Users',
            control: {type: 'array', required: true},
            defaultValue: [],
            description: 'The array of users'
        }
    },
};

const Template = (args) => ({
    components: {UserList},
    setup() {
        return {args};
    },
    template: '<user-list v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    users: [
        {
            id: 1,
            username: 'foobar'
        },
        {
            id: 2,
            username: 'xyzzy'
        }
    ]
};
