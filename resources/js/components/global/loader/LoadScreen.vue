<template>
    <div id="wrapper">
        <div id="container" class="container-tight py-6">
            <div class="text-center mb-4">
                <img id="logo" alt="Shoutz0r logo" src="@static/images/shoutzor-logo-header.png">
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="mb-3 text-center">Loading shoutz0r</h2>

                    <div class="text-center">
                        <p>Fetching data, please wait</p>
                        <div class="spinner-border" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoadScreen'
}
</script>

<style lang="scss" scoped>
#wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

#container {
    flex: none;
    height: initial;

    .card {
        border: 1px solid darken($body-bg, 5%);

        .card-body {
            background: lighten($body-bg, 5%);
        }
    }
}

#logo {
    filter: brightness(0) invert(1);
}
</style>
