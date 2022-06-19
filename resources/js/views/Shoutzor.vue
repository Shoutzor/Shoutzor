<template>
    <the-header id="header" />

    <div id="wrapper" class="d-flex flex-nowrap">
        <the-menu class="flex-column flex-shrink-0 p-3"/>

        <main id="main-content" class="d-flex flex-column flex-grow-1">
            <perfect-scrollbar ref="scroll">
                <div class="container">
                    <router-view/>
                </div>
            </perfect-scrollbar>
        </main>
    </div>

    <div class="position-relative bottom-0 order-3">
        <the-toastmanager />
    </div>

    <the-mediaplayer id="media-player" :volume="100" :playerStatus="'stopped'"/>
</template>

<script>
import TheHeader from '@components/TheHeader';
import TheMenu from '@components/TheMenu';
import TheMediaplayer from '@components/TheMediaplayer';
import TheToastmanager from "@components/TheToastmanager";

export default {
    name: "Shoutzor",
    components: {
        TheMediaplayer,
        TheHeader,
        TheMenu,
        TheToastmanager
    }
}
</script>

<style lang="scss" scoped>
#wrapper {
    padding-top: 1rem;
    padding-bottom: 0.5rem;
}

#wrapper main {
    .ps {
        flex: 1 1 auto;
        height: 0; // Required to make content scrollable, see: https://stackoverflow.com/a/14964944/1024322
    }
}
</style>
