<template>
    <div class="mediaVotes">
        <div class="row row-deck row-cards">
            <div v-for="vote in votes" class="col-sm-6 col-lg-3">
                <vote-card v-bind:vote="vote" v-bind:totalVotes="totalVotes"></vote-card>
            </div>
        </div>
    </div>
</template>

<script>
import VoteCard from "./VoteCard";
import MediaVote from "@js/models/MediaVote";

export default {
    components: {
        VoteCard
    },

    computed: {
        votes: () => MediaVote.query()
            .orderBy('count', 'desc')
            .with(["media.artist"])
            .get(),

        totalVotes: function () {
            return this.votes.reduce((total, vote) => {
                return total + vote.count
            }, 0)
        }
    }
}
</script>
