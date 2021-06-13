<template>
    <div class="card card-md">
        <div class="card-body text-center py-4 p-sm-4">
            <h1>Setup</h1>
            <p class="text-muted">This installer will guide you through the installation of Shoutz0r</p>
        </div>

        <div class="hr-text hr-text-center hr-text-spaceless">Healthcheck</div>

        <health-checker
            id="healthcheck"
            ref="healthcheck"
            v-bind:showTitle="false"
            refreshButtonClasses="btn btn-light"
            refreshButtonText="refresh"
            autoFixButtonClasses="btn btn-primary"
        ></health-checker>
    </div>
</template>

<script>
export default {
    name: "installer-start-view",
    components: {
    }
};
</script>

<style lang="scss">
#healthcheck {
    padding: 5px;
    margin-top: 5px;
}
</style>
