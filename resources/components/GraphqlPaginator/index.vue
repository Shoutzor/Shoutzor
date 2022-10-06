<template>
    <div class="graphql-paginator">
        <slot name="loading" v-if="isLoading">
            <base-spinner />
        </slot>

        <slot :items="itemsOnPage" v-else></slot>

        <BasePagination
            v-model="currentPage"
            :totalPages="totalPages"
            :onNavigate="onNavigate">
        </BasePagination>
    </div>
</template>

<script>
import {computed, reactive} from "vue";
import {DefaultApolloClient} from "@vue/apollo-composable";
import BaseSpinner from "@components/BaseSpinner";
import BasePagination from "@components/BasePagination";

export default {
    name: 'graphql-paginator',
    inject: [DefaultApolloClient],
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
            type: String,
            required: false,
            default: ''
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
            this.isLoading = true;
            this.beforePageChange();

            await this.DefaultApolloClient.query({
                query: this.queryObj,
                variables: {
                    limit: this.limit,
                    where: this.where
                }
            })
            .then((result) => {
                this.currentPage = page;
                this.itemsOnPage = result.data;
                this.afterPageChange();
            })
            .catch((error) => {
                console.log(error);
                this.bootstrapControl.showToast("error", "Could not load the results, error:" + error);
                this.afterPageChangeError();
            })
            .finally(() => {
                this.isLoading = false;
            });
        }
    }
}
</script>
