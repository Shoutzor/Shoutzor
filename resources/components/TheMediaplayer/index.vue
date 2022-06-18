<template>
    <div class="audio-player d-flex flex-wrap justify-content-between container-fluid">
        <div
            class="media-info d-inline-flex flex-grow-1 flex-shrink-0 flex-basis-0 align-items-center order-1 order-md-0">
            <div class="album-image d-inline-block pe-1">
                <img v-media-image-fallback class="rounded" :src="nowplaying?.media?.image || defaultMediaImage" alt="media image"/>
            </div>
            <div class="track-info d-inline-block">
                <template v-if="nowplaying">
                    <span class="track-title">{{ nowplaying.media.title }}</span>
                    <artist-list :artists="nowplaying.media.artists" class="text-muted"/>
                </template>
                <span v-else class="track-title">Now playing: Unavailable</span>
            </div>
        </div>
        <div
            class="media-control-container d-flex flex-fill flex-column flex-wrap align-items-center order-0 order-md-1">
            <div class="media-controls d-flex flex-fill align-items-center justify-content-center">
                <b-icon-hand-thumbs-up v-if="isAuthenticated && nowplaying" @click="$emit('mediaplayerUpvote')"
                                       class="upvote me-3"/>
                <play-button @click="$emit('mediaplayerPlay')" :state="playerStatus" class="mt-1"></play-button>
                <b-icon-hand-thumbs-down v-if="isAuthenticated && nowplaying"
                                         @click="$emit('mediaplayerDownvote')" class="downvote ms-3"/>
            </div>

            <div class="mt-1 mb-1 d-flex flex-fill">
                <base-progressbar
                    :pre-text="timePassed + '' || ''"
                    :post-text="timeDuration + '' || ''"
                    :current-value="percentagePlayed || 0"
                    class="col"/>
            </div>
        </div>
        <div
            class="extra-control d-inline-flex flex-grow-1 flex-shrink-0 flex-basis-0 align-items-center justify-content-end order-2">
            <div class="video-control" v-if="videoEnabled && playerStatus !== PlayerState.STOPPED"
                 @click="$emit('mediaplayerVideo')">
                <b-icon-tv/>
            </div>

            <div class="volume-control btn-group dropup">
                <b-icon-volume-up data-bs-toggle="dropdown" data-bs-auto-close="outside"/>
                <div class="dropdown-menu bg-dark" v-on:click.stop>
                    <vue-slider
                        v-model="volume"
                        direction="btt"
                        v-bind:max="100"
                        v-bind:min="0"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "./MediaPlayer.scss";

import VueSlider from 'vue-slider-component';
import {Dropdown} from 'bootstrap';

import {PlayerState} from "@models/PlayerState";
import BaseProgressbar from "@components/BaseProgressbar";
import PlayButton from "@components/PlayButton";
import ArtistList from "@components/ArtistList";
import BaseSpinner from "@components/BaseSpinner";

import {defaultMediaImage} from "@js/config";

export default {
    name: 'the-mediaplayer',
    components: {
        BaseSpinner,
        BaseProgressbar,
        Dropdown,
        VueSlider,
        PlayButton,
        ArtistList
    },
    data() {
        return {
            defaultMediaImage,
            PlayerState
        }
    },
    computed: {
        isAuthenticated() { return this.auth.isAuthenticated; },
        nowplaying() { return this.mediaPlayer.lastPlayed; },
        timePassed() { return 0; },
        timeDuration() { return this.nowplaying?.media?.duration; },

        percentagePlayed() {
            //TODO calculate from timePassed and timeDuration
            return 42;
        }
    },
    props: {
        volume: {
            type: Number,
            required: true,
            default: 100
        },
        playerStatus: {
            type: String,
            required: true,
            default: 'stopped'
        },
        videoEnabled: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    emits: ['mediaplayerUpvote', 'mediaplayerDownvote', 'mediaplayerPlay', 'mediaplayerVideo']
}
</script>
