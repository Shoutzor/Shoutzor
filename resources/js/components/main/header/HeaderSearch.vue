<template>
    <form v-on:submit.prevent="searchAction" class="d-flex">
        <input v-model="q" class="form-control" placeholder="Search…" type="text">
    </form>
</template>

<script>
export default {
    name: 'HeaderSearch',
    data() {
        return {
            q: ''
        }
    },
    methods: {
        searchAction: function() {
            this.$router.push({
                path: 'search',
                query: {q: this.q}
            });
            this.q = '';
        }
    }
}
</script>

<style lang="scss" scoped>
//Fix for search-field in navbar. Chrome adds this margin in the user agent stylesheet, but it's never reset.
form {
    margin-block-end: 0;
}
</style>
