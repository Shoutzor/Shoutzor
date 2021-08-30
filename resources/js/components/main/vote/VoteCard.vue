<template>
    <div class="card votecard" v-on:click="onVoteClick">
        <div :style="'background-image: url('+ vote.media.coverImage +')'" class="card-body">
            <div class="info">
                <div class="d-flex align-items-center">
                    <div class="subheader authors">
                        {{ vote.media.artist }}
                    </div>
                </div>
                <div class="h1 mb-3 title">{{ vote.media.title }}</div>
                <div class="voteresult d-flex">
                    <div>{{ vote.count }} Votes ({{ percentage }}%)</div>
                </div>
            </div>
        </div>
        <div class="progress progress-sm">
            <div :aria-valuenow="percentage" :style="'width: '+percentage+'%;'" aria-valuemax="100" aria-valuemin="0" class="progress-bar" role="progressbar">
                <span class="visually-hidden">{{ percentage }}% of total votes</span>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import MediaVote from "@js/models/MediaVote";

export default {
    props: {
        vote: MediaVote,
        totalVotes: {
            type: Number,
            default: 0
        }
    },

    computed: {
        percentage: function() {
            // Make sure the vote prop has been properly passed
            // as well as prevent a divide by zero exception
            if(typeof this.vote === undefined || this.vote.count === 0 || this.totalVotes === 0) {
                return 0;
            }

            return Math.round((this.vote.count / this.totalVotes) * 100);
        }
    },

    methods: {
        onVoteClick() {
            Vue.bus.emit('votes.vote', this.vote);
        }
    }
}
</script>

<style lang="scss" scoped>
.card:hover {
    box-shadow: 0 0 10px #282b2d;
    cursor: pointer;
}

.card-body {
    background-color: rgba(0, 0, 0, 0.1);
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url("~@static/images/album_cover_placeholder.jpg");
    background-position: 100px 25%;
    padding: 0;

    .info {
        background: linear-gradient(90deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 1) 40%, rgba(0, 0, 0, 0) 100%);
        padding: 0.75rem;
        height: 100%;

        .title {
            font-size: 1.25rem !important;
        }
    }
}

.progress {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: transparent;
    border-radius: 0;

    .progress-bar {
        background-color: rgba(200, 200, 200, 0.2);
        background-image: linear-gradient(
                45deg,
                rgba(255, 255, 255, .1) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255, 255, 255, .1) 50%,
                rgba(255, 255, 255, .1) 75%,
                transparent 75%,
                transparent
        );
        background-size: 4rem 4rem;
    }
}
</style>