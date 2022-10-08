<template>
    <div class="graphql-paginator">
        <slot name="loading" v-if="isLoading">
            <base-spinner />
        </slot>

        <slot :itemsOnPage="itemsOnPage" v-else></slot>

        <BasePagination
            v-model="currentPage"
            :totalPages="totalPages"
            :onNavigate="onNavigate">
        </BasePagination>
    </div>
</template>

<script>
import {computed, reactive} from "vue";
import BaseSpinner from "@components/BaseSpinner";
import BasePagination from "@components/BasePagination";

export default {
    name: 'graphql-paginator',
    components: {
        BaseSpinner,
        BasePagination
    },
    props: {
        queryObj: {
            type: Object,
            required: true
        },
        limit: {
            type: Number,
            required: false,
            default: 10
        },
        where: {
            type: Object,
            required: false,
            default: {}
        },
        beforePageChange: {
            type: Function,
            required: false,
            default: () => {}
        },
        afterPageChange: {
            type: Function,
            required: false,
            default: () => {}
        },
        afterPageChangeError: {
            type: Function,
            required: false,
            default: () => {}
        }
    },
    data() {
        return {
            isLoading: true,
            currentPage: 1,
            totalPages: 1,
            itemsOnPage: []
        }
    },
    setup(props) {
        props = reactive(props);

        return {
            classes: computed(() => ({
                'pagination': true,
                'pagination-sm': props.size === 'small',
                'pagination-lg': props.size === 'large',
                'justify-content-start': props.justify === 'start',
                'justify-content-center': props.justify === 'center',
                'justify-content-end': props.justify === 'end',
            }))
        }
    },
    mounted() {
        this.loadPage(1);
    },
    methods: {
        async onNavigate(page) {
            // Prevent queries when no change is taking place
            // or when the query is already loading
            if(this.currentPage === page || this.isLoading === true) {
                return;
            }

            await this.loadPage(page);
        },
        async loadPage(page) {
            this.beforePageChange();

            this.isLoading = true;
            this.currentPage = page;

            await this.apollo.query({
                query: this.queryObj,
                variables: {
                    page: this.currentPage,
                    limit: this.limit,
                    where: this.where
                }
            })
            .then((result) => {
                let data = Object.values(result.data)[0];
                this.totalPages = data.paginatorInfo.lastPage;
                this.itemsOnPage = data.data;
                this.afterPageChange();
            })
            .catch((error) => {
                this.bootstrapControl.showToast("danger", "Could not load the results, error:" + error);
                this.afterPageChangeError();
            })
            .finally(() => {
                this.isLoading = false;
            });
        }
    }
}
</script>
