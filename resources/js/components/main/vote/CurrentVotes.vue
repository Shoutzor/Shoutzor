<template>
    <div class="mediaVotes">
        <div class="row row-deck row-cards">
            <div v-for="vote in votes" class="col-sm-6 col-lg-3">
                <vote-card v-bind:vote="vote" v-bind:totalVotes="totalVotes"></vote-card>
            </div>
        </div>
        <modal-dialog
            ref="voteModal"
            title="Confirm Vote"
            v-slot="{ data: vote }">
            <p>Do you want to vote for {{ vote.title }}?</p>
        </modal-dialog>
    </div>
</template>

<script>
import Vue from "vue";
import VoteCard from "./VoteCard";
import ModalDialog from "@js/components/global/general/ModalDialog";
import MediaVote from "@js/models/MediaVote";

export default {
    components: {
        ModalDialog,
        VoteCard
    },

    computed: {
        votes: () => MediaVote.query()
                         .orderBy('count', 'desc')
                         .with(["media.artist"])
                         .get(),

        totalVotes: function() {
            return this.votes.reduce((total, vote) => {
                return total + vote.count
            }, 0)
        }
    },

    mounted() {
        Vue.bus.on('votes.vote', this.onVoteClick);
        Vue.bus.on('modal.cancel', this.onModalCancel);
        Vue.bus.on('modal.confirm', this.onModalConfirm);
    },

    beforeUnmount() {
        Vue.bus.off('votes.vote', this.onVoteClick);
        Vue.bus.off('modal.cancel', this.onModalCancel);
        Vue.bus.off('modal.confirm', this.onModalConfirm);
    },

    methods: {
        onVoteClick(voteItem) {
            this.$refs.voteModal.showModal(voteItem);
        },

        onModalCancel() {
            this.$refs.voteModal.hideModal();
            this.modalData = {};
        },

        onModalConfirm() {
            this.$refs.voteModal.hideModal();
            this.modalData = {};
        }
    }
}
</script>

<style lang="scss">

</style>