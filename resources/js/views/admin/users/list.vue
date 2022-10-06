<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h1>Manage users</h1>

            <graphql-paginator />
        </div>
    </div>
</template>

<script>
import GraphqlPaginator from "@components/GraphqlPaginator";

export default {
    name: "admin-users",
    components: {
        GraphqlPaginator
    }
};
</script>
