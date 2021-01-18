<template>
    <div>
        <div class="card">
            <div class="list-group card-list-group">
                <div class="list-group-item"
                     v-if="packages"
                     v-for="pkg in packages">
                    <div class="row row-sm align-items-center" :id="'package-' + pkg.id">
                        <div class="col-auto">
                            <img :src="'/storage/packages/' + pkg.id + '/' + pkg.icon" class="rounded" alt="package logo" width="48" height="48">
                        </div>
                        <div class="col">
                            {{pkg.name}}
                            <span class="badge bg-gray-lt">Version {{pkg.version}}</span>
                            <div class="text-muted">
                                {{pkg.description}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <a v-if="pkg.enabled"
                               v-on:click.prevent="disablePackage(pkg)"
                               href="#" class="btn btn-danger">
                                Disable
                            </a>
                            <a v-else
                               v-on:click.prevent="enablePackage(pkg)"
                               href="#" class="btn btn-outline-success">
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
    </div>
</template>

<script>
    import Package from '@js/models/Package';
    import axios from "axios";

    export default {
        computed: {
            packages: () => Package.query().all()
        },

        mounted() {
            Package.api().fetch();
        },

        methods: {
            enablePackage(pkg) {
                axios.post('/api/package/enable', {
                    id: pkg.id
                }).then(res => {
                    Package.insert(res);
                }).catch(err => {

                });
            },

            disablePackage(pkg) {
                axios.post('/api/package/disable', {
                    id: pkg.id
                }).then(res => {
                    Package.insert(res);
                }).catch(err => {

                });
            }
        }
    }
</script>

<style lang="scss">

</style>
