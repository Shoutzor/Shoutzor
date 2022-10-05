<template>
    <div class="row row-cards">
        <div class="col-sm-12">
            <h1>Manage users</h1>

            <base-pagination
                v-model="currentPage"
                :totalPages="10"
                :onNavigate="doNav"
                ></base-pagination>
        </div>
    </div>
</template>

<script>
import BasePagination from "@components/BasePagination";
export default {
    name: "admin-users",
    components: {
        BasePagination
    },
    data() {
        return {
            currentPage: 1
        }
    },
    methods: {
        doNav(page) {
            this.currentPage = page;
        }
    }
};
</script>
