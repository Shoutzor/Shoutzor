<template>
    <div class="audio-player d-flex flex-wrap justify-content-between">
        <div class="media-info d-inline-flex align-items-center order-1 order-md-0">
            <div class="album-image d-inline-block pe-1">
                <img v-if="nowPlaying" class="rounded" height="48" v-bind:src="nowPlaying.coverImage" width="48">
                <b-icon-question v-else class="rounded border" height="48" width="48" />
            </div>
            <div class="track-info d-inline-block">
                <template v-if="nowPlaying">
                    <span class="track-title">{{ nowPlaying.title }}</span>
                    <artist-list :artists="nowPlaying.artists" class="text-muted" />
                </template>
                <span v-else class="track-title">Now playing: Unavailable</span>
            </div>
        </div>
        <div class="media-control-container d-flex flex-fill flex-column flex-wrap align-items-center order-0 order-md-1">
            <div class="media-controls d-flex flex-fill align-items-center justify-content-center">
                <b-icon-hand-thumbs-up v-if="isAuthenticated" @click="$emit('mediaplayerUpvote')" class="upvote me-3" />
                <play-button @click="$emit('mediaplayerPlay')" :state="playerStatus"></play-button>
                <b-icon-hand-thumbs-down v-if="isAuthenticated" @click="$emit('mediaplayerDownvote')" class="downvote ms-3" />
            </div>

            <div class="mt-2 d-flex flex-fill">
                <base-progressbar
                    :pre-text="nowPlaying.timePassed"
                    :post-text="nowPlaying.timeRemaining"
                    :current-value="nowPlaying.percentagePlayed"
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

import {computed, reactive} from "vue";
import VueSlider from 'vue-slider-component';
import { Dropdown } from 'bootstrap';

import BaseProgressbar from "@components/BaseProgressbar";
import PlayButton from "@components/PlayButton";
import ArtistList from "@components/ArtistList";

export default {
    components: {
        Dropdown,
        VueSlider,
        BaseProgressbar,
        PlayButton,
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

    emits: ['mediaplayerUpvote', 'mediaplayerDownvote', 'mediaplayerPlay', 'mediaplayerVideo']
}
</script>
