<template>
    <div class="mediaVotes">
        <div class="row">
            <vote-card v-for="vote in votes" :vote="vote" :totalVotes="totalVotes"></vote-card>
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
            .with(["media.artists"])
            .limit(10)
            .get(),

        totalVotes: function () {
            return this.votes.reduce((total, vote) => {
                return total + vote.count
            }, 0)
        }
    }
}
</script>
