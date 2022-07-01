<template>
    <base-button class="btn-outline-primary btn-small request-button" @click="onClick">
        Request
    </base-button>
</template>

<script>
import BaseButton from "@components/BaseButton";
import {useMutation} from "@vue/apollo-composable";
import {ADDREQUEST_MUTATION} from "@graphql/requests";

export default {
    name: 'request-button',
    components: {
        BaseButton
    },
    data() {
        return {
            modalId: null
        }
    },
    props: {
        id: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    },
    methods: {
        onClick() {
            this.modalId = this.bootstrapControl.showModal({
                onConfirm: this.doRequest,
                body: `Do you want to request: ${this.title}?`,
                confirmButton: 'Request'
            });
        },

        doRequest() {
            let modalProperties = this.bootstrapControl.getModalProperties(this.modalId);

            modalProperties.loading = true;

            const { mutate: addRequestMutate } = useMutation(ADDREQUEST_MUTATION, {
                fetchPolicy: 'no-cache',
                variables: {
                    id: this.id
                }
            });

            addRequestMutate()
                .then(result => {
                    if(result.data.addRequest.success) {
                        this.bootstrapControl.showToast("success", "Your request has been added to the queue");
                    } else {
                        this.bootstrapControl.showToast("danger", result.data.addRequest.message);
                    }
                })
                .catch(error => {
                    this.bootstrapControl.showToast("danger", "Something went wrong while processing your request");
                })
                .finally(() => {
                    this.bootstrapControl.hideModal(this.modalId);
                    modalProperties.loading = false;
                });
        }
    }
};
</script>
