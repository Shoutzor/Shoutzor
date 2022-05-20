<template>
    <div class="audio-player">
        <div class="media-info">
            <div v-if="nowPlaying" class="row row-sm align-items-center ps-2">
                <div class="col-auto">
                    <img class="rounded" height="48" v-bind:src="nowPlaying.coverImage" width="48">
                </div>
                <div class="col">
                    <span class="track-title">{{ nowPlaying.title }}</span>
                    <artist-list :artists="nowPlaying.artists" class="text-muted"></artist-list>
                </div>
            </div>
            <div v-else class="row row-sm align-items-center ps-2">
                <div class="col-auto ">
                    <b-icon-question
                        class="rounded border"
                        height="48"
                        width="48"
                    ></b-icon-question>
                </div>
                <div class="col">
                    <span class="track-title">Now playing: Unavailable</span>
                </div>
            </div>;
        </div>
        <div class="media-control-container">
            <div class="media-controls">
                <b-icon-hand-thumbs-up @click="$emit('mediaplayer-upvote')" v-if="isAuthenticated" class="upvote"></b-icon-hand-thumbs-up>
                <play-button @click="$emit('mediaplayer-play')" :state="playerStatus"></play-button>
                <b-icon-hand-thumbs-down @click="$emit('mediaplayer-downvote')" v-if="isAuthenticated" class="downvote"></b-icon-hand-thumbs-down>
            </div>
            <base-progressbar :pre-text="'01:45'" :post-text="'4:31'" :current-value="42"></base-progressbar>
        </div>
        <div class="extra-control">
            <div class="video-control" v-if="videoEnabled && playerStatus !== PlayerState.STOPPED" @click="$emit('mediaplayer-video')">
                <b-icon-tv></b-icon-tv>
            </div>

            <div class="volume-control" class="btn-group dropup">
                <b-icon-volume-up
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                ></b-icon-volume-up>
                <div class="dropdown-menu bg-dark" v-on:click.stop>
                    <vue-slider
                        v-model="volume"
                        direction="btt"
                        v-bind:max="100"
                        v-bind:min="0"
                        @change="$emit('mediaplayer-volume')"
                    ></vue-slider>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueSlider from 'vue-slider-component';

import BaseProgressbar from "@components/BaseProgressbar";
import PlayButton from "@components/PlayButton";
import ArtistList from "@components/ArtistList";

import PlayerState from "@js/store/modules/MediaPlayer/PlayerState";

export default {
    components: {
        BaseProgressbar,
        PlayButton,
        VueSlider,
        ArtistList
    },
    props: {
        nowPlaying: {
            type: Object,
            required: false,
            default: null
        },
        volume: {
            type: Number,
            required: true,
            default: 100
        },
        playerStatus: {
            type: String,
            required: true,
            default: PlayerState.STOPPED
        },
        isAuthenticated: {
            type: Boolean,
            required: false,
            default: false
        },
        videoEnabled: {
            type: Boolean,
            required: false,
            default: false
        }
    }
}
</script>
