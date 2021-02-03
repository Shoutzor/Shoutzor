<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-12">
                <h2 class="search-header">%i search results for "{{ $route.query.q }}"</h2>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-sm-12 searchresults">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card searchresult">
                            <div class="row row-0">
                                <div class="col-sm-1">
                                    <img src="images/album_temp_bg.jpg" class="previewimage object-cover" alt="Search result image">
                                </div>
                                <div class="col">
                                    <div class="card-body searchresult-content">
                                        <h3 class="card-title">Ghosts 'n stuff</h3>
                                        <span><a class="artist" href="#">deadmau5</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card searchresult">
                            <div class="row row-0">
                                <div class="col-sm-1">
                                    <span class="avatar mediatype video bg-orange-lt object-cover">
                                        <movie-icon class="mediasource-icon"></movie-icon>
                                     </span>
                                </div>
                                <div class="col">
                                    <div class="card-body searchresult-content">
                                        <h3 class="card-title">Ghosts 'n stuff</h3>
                                        <span><a class="artist" href="#">deadmau5</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card searchresult">
                            <div class="row row-0">
                                <div class="col-sm-1">
                                    <span class="avatar mediatype audio bg-azure-lt object-cover">
                                        <music-icon class="mediasource-icon"></music-icon>
                                     </span>
                                </div>
                                <div class="col">
                                    <div class="card-body searchresult-content">
                                        <h3 class="card-title">Ghosts 'n stuff</h3>
                                        <span><a class="artist" href="#">deadmau5</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import ComingUp from "@js/components/MediaTable/ComingUp";
    import ArtistList from "../../components/media/ArtistList";

    export default {
        name: "search-view",
        components: {
            ArtistList,
            ComingUp
        }
    };
</script>

<style scoped lang="scss">
    .search-header {
        margin: 0 0 0.5rem;
        opacity: 0.25;
        font-size: 2rem;
    }

    .searchresults {
        & > .row {
            margin-bottom: 5px;
        }

        .searchresult {
            .object-cover {
                width: 100%;
                height: 100%;
                min-height: inherit;

                &.previewimage {
                    height: auto;
                }
            }

            .searchresult-content h3 {
                flex-grow: 1;
            }
        }
    }
</style>
