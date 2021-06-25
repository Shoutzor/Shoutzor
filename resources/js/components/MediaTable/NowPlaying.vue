<template>
  <div v-if="currentRequest" class="col-sm-12 nowplaying">
    <div class="track-background">
      <img class="album-image" v-bind:src="currentRequest.media.coverImage"/>
      <div class="album-overlay"></div>
    </div>
    <div class="track-content card card-aside">
      <img alt="album image" class="album-image card-aside-column" v-bind:src="currentRequest.media.coverImage"/>
      <div class="track-info card-body d-flex flex-column mt-auto">
        <h3 v-if="currentRequest.media !== null">{{ currentRequest.media.title }}</h3>
        <artist-list :artists="currentRequest.media.artists"></artist-list>

        <div class="d-flex align-items-center mt-auto">
          <div class="requested-by pl-3">
            <small class="text-muted">Requested by</small>
            <div v-if="currentRequest.user !== null">{{ currentRequest.user.name }}</div>
            <div v-if="currentRequest.user === null">AutoDJ</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Request from '@js/models/Request';

export default {
  computed: {
    currentRequest: () => Request.query()
        .where((r) => {
          return r.played_at !== null;
        })
        .with(["media.artists|albums", "user"])
        .last()
  }
}
</script>

<style lang="scss">
.nowplaying {
  position: relative;
  width: 100%;
  height: 240px;
  overflow: hidden;

  .track-background {
    z-index: -9999;

    .album-image {
      position: absolute;
      min-width: 100%;
      top: -115%;
      filter: blur(2px);
    }

    .album-overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.1);
      background-repeat: repeat;
      background-position: -7px 0px;
      background-size: contain;
      background-image: url("~@static/images/nowplaying_overlay.png");
    }
  }

  .track-content {
    position: absolute;
    background: transparent;
    border: 0;
    box-shadow: none;
    bottom: 8px;
    left: 10px;
    flex-direction: row;

    .album-image {
      $imageSize: 200px;
      min-width: $imageSize;
      max-width: $imageSize;
      min-height: $imageSize;
      max-height: $imageSize;
      box-shadow: 0 0 2px #000;
    }

    .track-info {
      padding: 0.5rem 0.5rem 0.1rem 0.5rem;
      color: #FFF;
      text-shadow: 0 0 4px #000;

      h3 {
        font-size: 1.4rem;
        margin-bottom: 1px;
      }

      .artists {
        font-size: 1rem;
        margin-bottom: 0.2rem;
      }

      .requested-by {
        border-left: 1px solid #FFF;
        padding-left: 5px;

        .text-muted {
          color: #929394 !important;
        }
      }

      a.artist, .upvote, .downvote {
        color: #fff;

        &:hover {
          color: $gray;
        }
      }

      .downvote {
        margin: 0 10px;
      }
    }
  }

  @media (max-width: map-get($grid-breakpoints, lg)) {
    height: 150px;

    .track-background > .album-image {
      min-width: 150%;
      top: -200%;
      left: -25%;
    }

    .track-content {
      .album-image {
        $imageSize: 100px;
        min-width: $imageSize;
        max-width: $imageSize;
        min-height: $imageSize;
        max-height: $imageSize;
      }

      .track-info {
        padding: 0 0 0 0.5rem;
        margin-top: -5px !important;
      }
    }
  }

  @media (max-width: map-get($grid-breakpoints, md)) {
    .track-background > .album-image {
      min-width: 200%;
      top: -150%;
      left: -50%;
    }
  }
}
</style>
