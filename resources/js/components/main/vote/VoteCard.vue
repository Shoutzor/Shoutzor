<template>
    <div class="col votecard dark" v-on:click="onVoteClick" ref="voteCard">
        <div class="votecard-body" :style="'background-image: url('+ vote.media.coverImage +')'">
            <div class="info">
                <div class="title mb-1">{{ vote.media.title }}</div>
                <div class="subheader authors" v-if="vote.media.artists.length > 0">
                    <template v-if="vote.media.artists.length === 1">{{ vote.media.artists[0].name }}</template>
                    <template v-else>Various Artists</template>
                </div>
                <div class="voteresult">
                    <div>{{ vote.count }} Vote(s) ({{ percentage }}%)</div>
                </div>
            </div>
        </div>
        <div class="progress">
            <div :aria-valuenow="percentage" :style="'width: '+percentage+'%;'" aria-valuemax="100" aria-valuemin="0" class="progress-bar" role="progressbar">
                <span class="visually-hidden">{{ percentage }}% of total votes</span>
            </div>
        </div>
    </div>
</template>

<script>
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
            this.emitter.emit('votes.vote', this.vote);
        },

        updateVotecardColor() {
            if(typeof this.vote === undefined || typeof this.vote.media.coverImage === undefined) {
                return;
            }

            this.fac.getColorAsync(this.vote.media.coverImage)
                .then(color => {
                    // Set the color of the votecard based on the avg. color of it's cover image
                    this.$refs.voteCard.style.setProperty('--voteCardColor', color.hex);

                    // Update the class of the votecard based on the avg. color of it's cover image
                    this.$refs.voteCard.classList.remove(color.isDark ? 'light' : 'dark');
                    this.$refs.voteCard.classList.add(color.isDark ? 'dark' : 'light');
                });
        }
    },

    mounted() {
        this.updateVotecardColor();
    },

    updated() {
        this.updateVotecardColor();
    }
}
</script>

<style lang="scss" scoped>
.votecard {
    position: relative;
    overflow: hidden;
    border-radius: 5px;
    --width: 260px;
    min-width: var(--width);
    width: var(--width);
    max-width: var(--width);
    padding: 0;
    margin: 5px;
    color: #fff;
    text-shadow: 0 0 4px rgb(0 0 0);
    --voteCardColor: $gray;

    &:hover {
        box-shadow: 0 0 10px var(--voteCardColor);
        cursor: pointer;
    }

    .votecard-body {
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("~@static/images/album_cover_placeholder.jpg");
        background-position: 100px 25%;
        padding: 0;

        .info {
            position: relative;
            padding: 0.75rem;
            height: 8rem;
            background-image: linear-gradient(90deg, var(--voteCardColor) 0%, var(--voteCardColor) 40%, rgba(0, 0, 0, 0) 100%);

            .title {
                font-size: 1rem !important;
                line-height: 1rem;
            }

            .authors {
                text-shadow: none;
            }

            .voteresult {
                position: absolute;
                bottom: 5px;
                font-size: 0.75rem;
                line-height: 0.75rem;
                align-self: flex-end;
            }
        }
    }

    .progress {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: transparent;
        border-radius: 0;

        .progress-bar {
            background-size: 4rem 4rem;
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
        }
    }

    &.light {
        .info .authors {
            color: $gray-dark;
        }

        .progress .progress-bar {
            background-color: rgba(0, 0, 0, 0.2);
        }
    }

    &.dark {
        .info .authors {
            color: $white;
        }

        .progress .progress-bar {
            background-color: rgba(200, 200, 200, 0.2);
        }
    }
}
</style>
