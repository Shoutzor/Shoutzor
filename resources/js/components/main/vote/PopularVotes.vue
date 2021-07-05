<template>
    <div class="mediaVotes">
        <div class="row row-deck row-cards">
            <div v-for="vote in votes" class="col-sm-6 col-lg-3">
                <vote-card v-bind:media="vote"></vote-card>
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

export default {
    components: {
        ModalDialog,
        VoteCard
    },

    data() {
        return {
            votes: [
                {
                    title: 'Ghosts \'n stuff',
                    artist: 'Deadmau5',
                    album: [
                        {
                            image: 'album_temp_bg.jpg'
                        }
                    ],
                    votes: 10,
                    percentage: 62
                }, {
                    title: 'Right Round',
                    artist: 'Deadmau5',
                    album: [
                        {
                            image: 'album_temp_bg.jpg'
                        }
                    ],
                    votes: 4,
                    percentage: 25
                }, {
                    title: 'I kissed a girl (and I liked it)',
                    artist: 'Katy Perry',
                    album: [
                        {
                            image: 'album_cover_placeholder.jpg'
                        }
                    ],
                    votes: 2,
                    percentage: 12.5
                }
            ]
        };
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

<style lang="scss" scoped>

</style>