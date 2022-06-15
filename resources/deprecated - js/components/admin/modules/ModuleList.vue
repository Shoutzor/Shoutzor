<template>
    <div>
        <div class="card">
            <div class="list-group card-list-group">
                <div v-for="m in modules"
                     v-if="modules"
                     class="list-group-item">
                    <div :id="'module-' + pkg.id" class="row row-sm align-items-center">
                        <div class="col-auto">
                            <img :src="'/storage/modules/' + m.id + '/' + m.icon" alt="package logo" class="rounded"
                                 height="48"
                                 width="48">
                        </div>
                        <div class="col">
                            {{ m.name }}
                            <span class="badge bg-gray-lt">Version {{ m.version }}</span>
                            <div class="text-muted">
                                {{ m.description }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <a v-if="m.enabled"
                               class="btn btn-danger"
                               href="#" v-on:click.prevent="disableModule(m)">
                                Disable
                            </a>
                            <a v-else
                               class="btn btn-outline-success"
                               href="#" v-on:click.prevent="enableModule(m)">
                                Enable
                            </a>
                        </div>
                    </div>
                </div>
                <div v-else class="list-group-item">
                    <div class="col-auto">
                        No modules installed
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Module from '@js/models/Module';
import axios from "axios";

export default {
    computed: {
        modules: () => Module.query().all()
    },

    mounted() {
        Module.api().fetch();
    },

    methods: {
        enableModule(module) {
            axios.post('/api/modules/enable', {
                id: module.id
            }).then(res => {
                Module.insert(res);
            }).catch(err => {

            });
        },

        disableModule(module) {
            axios.post('/api/modules/disable', {
                id: module.id
            }).then(res => {
                Module.insert(res);
            }).catch(err => {

            });
        }
    }
}
</script>

<style lang="scss">

</style>
