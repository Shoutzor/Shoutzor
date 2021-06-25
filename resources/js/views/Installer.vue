<template>
  <div id="installer_wrapper">
    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="text-center mb-4">
          <img alt="Shoutz0r logo" src="@static/images/shoutzor-logo-large.png">
        </div>

        <router-view></router-view>

        <div class="row align-items-center mt-3">
          <div class="col-4">
            <div class="progress">
              <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar" role="progressbar"
                   style="width: 5%">
                <span class="visually-hidden">5% Complete</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="btn-list justify-content-end">
              <a class="btn btn-link link-secondary" href="#">
                Go back
              </a>
              <a class="btn btn-primary" href="#">
                Continue
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Installer",
}
</script>

<style lang="scss" scoped>

</style>
