<template>
    <form action="../search" method="get">
        <div class="input-icon">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <circle cx="10" cy="10" r="7" />
                    <line x1="21" y1="21" x2="15" y2="15" />
                </svg>
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
