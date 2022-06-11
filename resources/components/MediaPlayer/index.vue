<template>
    <div class="audio-player d-flex flex-wrap justify-content-between">
        <div class="media-info d-inline-flex align-items-center order-1 order-md-0">
            <div class="album-image d-inline-block pe-1">
                <img v-if="currentMedia" class="rounded" height="48" :src="currentMedia.image" width="48">
                <b-icon-question v-else class="rounded border" height="48" width="48" />
            </div>
            <div class="track-info d-inline-block">
                <template v-if="currentMedia">
                    <span class="track-title">{{ currentMedia.title }}</span>
                    <artist-list :artists="currentMedia.artists" class="text-muted" />
                </template>
                <span v-else class="track-title">Now playing: Unavailable</span>
            </div>
        </div>
        <div class="media-control-container d-flex flex-fill flex-column flex-wrap align-items-center order-0 order-md-1">
            <div class="media-controls d-flex flex-fill align-items-center justify-content-center">
                <b-icon-hand-thumbs-up v-if="isAuthenticated && currentMedia" @click="$emit('mediaplayerUpvote')" class="upvote me-3" />
                <play-button @click="$emit('mediaplayerPlay')" :state="playerStatus"></play-button>
                <b-icon-hand-thumbs-down v-if="isAuthenticated && currentMedia" @click="$emit('mediaplayerDownvote')" class="downvote ms-3" />
            </div>

            <div v-if="currentMedia" class="mt-1 mb-1 d-flex flex-fill">
                <base-progressbar
                    :pre-text="timePassed || ''"
                    :post-text="timeDuration || ''"
                    :current-value="percentagePlayed || 0"
                    class="col" />
            </div>
        </div>
        <div class="extra-control d-inline-flex align-items-center order-2">
            <div class="video-control" v-if="videoEnabled && playerStatus !== PlayerState.STOPPED" @click="$emit('mediaplayerVideo')">
                <b-icon-tv />
            </div>

            <div class="volume-control btn-group dropup">
                <b-icon-volume-up data-bs-toggle="dropdown" data-bs-auto-close="outside" />
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
import { Dropdown } from 'bootstrap';

import { PlayerState } from "@models/PlayerState";
import BaseProgressbar from "@components/BaseProgressbar";
import PlayButton from "@components/PlayButton";
import ArtistList from "@components/ArtistList";

export default {
    name: 'media-player',
    components: {
        Dropdown,
        VueSlider,
        BaseProgressbar,
        PlayButton,
        ArtistList
    },
    data() {
        return {
            PlayerState
        }
    },
    props: {
        currentMedia: {
            type: Object,
            required: false,
            default: {}
        },
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
    },

    computed: {
        timePassed() {
            return 0;
        },

        timeDuration() {
            return this.currentMedia ? this.currentMedia.duration : null;
        },

        percentagePlayed() {
            //TODO calculate from timePassed and timeDuration
            return 42;
        }
    },

    emits: ['mediaplayerUpvote', 'mediaplayerDownvote', 'mediaplayerPlay', 'mediaplayerVideo']
}
</script>
