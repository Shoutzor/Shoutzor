import BaseTable from '@components/BaseTable';

export default {
    title: 'base/BaseTable',
    component: BaseTable,
    argTypes: {
        hoverable: {
            name: 'Hoverable',
            type: {name: 'boolean', required: false},
            description: 'Whether to apply a hover effect on the rows'
        },
        striped: {
            name: 'Striped',
            type: {name: 'select', required: false},
            options: ['row', 'column'],
            description: 'If rows, columns or neither should be striped'
        },
        border: {
            name: 'Border',
            type: {name: 'boolean', required: false},
            description: 'Whether borders should be applied or not'
        },
        compact: {
            name: 'Compact',
            type: {name: 'boolean', required: false},
            description: 'Whether the table should be compacted (less cell-padding)'
        }
    },
};

const Template = (args) => ({
    components: {BaseTable},
    setup() {
        return {args};
    },
    template: `
      <base-table v-bind="args">
        <template #header>${args.header}</template>
        <template v-slot>${args.slot}</template>
      </base-table>`,
});

export const Example = Template.bind({});
Example.args = {
    hoverable: true,
    striped: 'row',
    border: true,
    compact: false,
    header: `
        <tr>
            <th>ID</th>
            <th>Data</th>
        </tr>
    `,
    slot: `
        <tr>
            <td>1</td>
            <td>Some data</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Some more data</td>
        </tr>
    `
};
