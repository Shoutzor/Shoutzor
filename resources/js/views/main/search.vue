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
                                    <span class="object-cover">
                                        <img alt="Search result image" class="previewimage"
                                             src="images/album_temp_bg.jpg">
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
                                    <span class="object-cover">
                                        <img alt="Search result image" class="previewimage"
                                             src="https://i.ytimg.com/vi/qv1aEfLgiWM/default.jpg">
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
import ComingUp from "@js/components/main/MediaTable/ComingUp";
import ArtistList from "@js/components/main/media/ArtistList";

export default {
  name: "search-view",
  components: {
    ArtistList,
    ComingUp
  }
};
</script>

<style lang="scss" scoped>
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
      display: flex;
      align-items: center;
      max-width: 96px;
      min-width: 96px;
      max-height: 96px;
      min-height: 96px;

      &.avatar svg {
        width: 2rem;
        height: 2rem;
      }

      .previewimage {
        min-height: 0;
        height: auto;
        width: 100%;
        max-width: inherit;
      }
    }

    .searchresult-content h3 {
      flex-grow: 1;
    }
  }
}
</style>
