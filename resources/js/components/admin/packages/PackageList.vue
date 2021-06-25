<template>
  <div>
    <div class="card">
      <div class="list-group card-list-group">
        <div v-for="pkg in packages"
             v-if="packages"
             class="list-group-item">
          <div :id="'package-' + pkg.id" class="row row-sm align-items-center">
            <div class="col-auto">
              <img :src="'/storage/packages/' + pkg.id + '/' + pkg.icon" alt="package logo" class="rounded" height="48"
                   width="48">
            </div>
            <div class="col">
              {{ pkg.name }}
              <span class="badge bg-gray-lt">Version {{ pkg.version }}</span>
              <div class="text-muted">
                {{ pkg.description }}
              </div>
            </div>
            <div class="col-auto">
              <a v-if="pkg.enabled"
                 class="btn btn-danger"
                 href="#" v-on:click.prevent="disablePackage(pkg)">
                Disable
              </a>
              <a v-else
                 class="btn btn-outline-success"
                 href="#" v-on:click.prevent="enablePackage(pkg)">
                Enable
              </a>
            </div>
          </div>
        </div>
        <div v-else class="list-group-item">
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
