<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h1>Manage users</h1>

            <graphql-paginator
                :queryObj="LIST_USERS_QUERY"
                :limit="4"
                v-slot="props"
            >
                <table>
                    <thead>
                        <tr><th>Username</th></tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in props.itemsOnPage">
                            <td>{{ item.username }}</td>
                        </tr>
                    </tbody>
                </table>
            </graphql-paginator>
        </div>
    </div>
</template>

<script>
import GraphqlPaginator from "@components/GraphqlPaginator";
import { LIST_USERS_QUERY } from "@graphql/users";

export default {
    name: "admin-users",
    components: {
        GraphqlPaginator
    },
    data() {
        return {
            LIST_USERS_QUERY
        };
    }
};
</script>
