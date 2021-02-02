r<template>
    <form v-on:submit.prevent="searchAction">
        <div class="input-icon">
            <span class="input-icon-addon">
                <search-icon
                    class="icon"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                ></search-icon>
            </span>
            <input v-model="q" type="text" class="form-control" placeholder="Search…">
        </div>
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
                this.$router.push({ path: 'search', query: { q: this.q }});
                this.q = '';
            }
        }
    }
</script>

<style scoped lang="scss">
    //Fix for search-field in navbar. Chrome adds this margin in the user agent stylesheet, but it's never reset.
    form {
        margin-block-end: 0;
    }
</style>
