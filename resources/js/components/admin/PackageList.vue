<template>
    <div class="card">
        <div class="list-group card-list-group">
            <div class="list-group-item"
                 v-if="packages"
                 v-for="pkg in packages">
                <div class="row row-sm align-items-center">
                    <div class="col-auto">
                        <img :src="pkg.logo" class="rounded" alt="package logo" width="48" height="48">
                    </div>
                    <div class="col">
                        {{pkg.name}}
                        <div class="text-muted">
                            {{pkg.description}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="link-secondary">
                            Update
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="link-secondary">
                            Enable
                        </a>
                    </div>
                </div>
            </div>
            <div class="list-group-item" v-else>
                <div class="col-auto">
                    No packages installed
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Package from '@js/models/Package';

    export default {
        computed: {
            packages: () => Package.query().all()
        },

        mounted() {
            Package.api().fetch();
        }
    }
</script>

<style lang="scss">

</style>
