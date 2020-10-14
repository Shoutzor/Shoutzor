<template>
    <div>
        <div class="card d-flex flex-column"
             v-if="packages"
             v-for="pkg in packages">
            <div class="row row-0 flex-fill">
                <div class="col-auto">
                    <img :src="'/storage/packages/' + pkg.id + '/' + pkg.icon" alt="package logo" width="64" height="64">
                </div>
                <div class="col-auto ml-2 card-body">
                    <h3 class="card-title">{{pkg.name}}</h3>
                    <div class="text-muted">{{pkg.description}}</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="list-group card-list-group">
                <div class="list-group-item"
                     v-if="packages"
                     v-for="pkg in packages">
                    <div class="row row-sm align-items-center">
                        <div class="col-auto">
                            <img :src="'/storage/packages/' + pkg.id + '/' + pkg.icon" class="rounded" alt="package logo" width="48" height="48">
                        </div>
                        <div class="col">
                            {{pkg.name}}
                            <span class="badge bg-gray-lt">Version {{pkg.version}}</span>
                            <span class="badge bg-orange-lt">Update Available</span>
                            <div class="text-muted">
                                {{pkg.description}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-outline-warning">
                                Update
                            </a>
                        </div>
                        <div class="col-auto">
                            <a v-if="pkg.enabled" href="#" class="btn btn-danger">Disable</a>
                            <a v-else href="#" class="btn btn-outline-success">Enable</a>
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
