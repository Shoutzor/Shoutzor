<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h1 class="mb-4">Manage Roles</h1>

            <graphql-paginator
                :queryObj="LIST_ROLES_QUERY"
                :limit="8"
                v-slot="props"
            >
                <base-table
                    description="Lists all roles"
                    :hoverable="true"
                >
                    <template #header>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </template>
                    <template #default>
                        <tr v-if="props.itemsOnPage.length > 0"
                            v-for="role in props.itemsOnPage"
                        >
                            <td>
                                {{ role.name }}
                            </td>
                            <td>
                                {{ role.description }}
                            </td>
                            <td>
                                <base-button class="btn-outline-primary">Edit</base-button>
                                <base-button :disabled="role.protected"
                                             class="ms-2 btn-outline-danger"
                                >Delete</base-button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="3">No roles found</td>
                        </tr>
                    </template>
                </base-table>
            </graphql-paginator>
        </div>
    </div>
</template>

<script>
import { LIST_ROLES_QUERY } from "@graphql/roles";
import GraphqlPaginator from "@components/GraphqlPaginator";
import BaseTable from "@components/BaseTable";
import BaseButton from "@components/BaseButton";

export default {
    name: "admin-roles",
    components: {
        BaseButton,
        BaseTable,
        GraphqlPaginator
    },
    data() {
        return {
            LIST_ROLES_QUERY
        }
    }
};
</script>
