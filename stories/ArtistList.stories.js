import ArtistList from '@components/ArtistList';

export default {
    title: 'general/ArtistList',
    component: ArtistList,
    argTypes: {
        artists: {
            name: 'Artists',
            control: {type: 'array', required: true},
            defaultValue: [],
            description: 'The array of artists'
        }
    },
};

const Template = (args) => ({
    components: {ArtistList},
    setup() {
        return {args};
    },
    template: '<artist-list v-bind="args" />',
});

export const Example = Template.bind({});
Example.args = {
    artists: [
        {
            id: 1,
            name: 'Foo Bar'
        },
        {
            id: 2,
            name: 'Xyz Zy'
        }
    ]
};
