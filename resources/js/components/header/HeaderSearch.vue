<template>
    <form action="../search" method="get">
        <div class="input-icon">
            <span class="input-icon-addon">
                <search-icon
                    class="icon"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                ></search-icon>
            </span>
            <input type="text" class="form-control" placeholder="Search…">
        </div>
    </form>
</template>

<script>
    export default {
        name: 'HeaderSearch',
        data() {
            return {

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
