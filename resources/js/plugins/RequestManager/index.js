import {useMutation} from "@vue/apollo-composable";
import {ADDREQUEST_MUTATION} from "@graphql/requests";

class RequestManager {

    #bootstrapControl
    #modalId

    constructor(bootstrapControl) {
        this.#bootstrapControl = bootstrapControl;
        this.#modalId = null;
    }

    request(id, title) {
        // Making sure nothing in the media title can cause an XSS vulnerability
        let escapedTitle = String(title)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');

        this.#modalId = this.#bootstrapControl.showModal({
            onConfirm: () => { this.#makeRequest(id); },
            body: `Do you want to request: <strong>${escapedTitle}</strong>?`,
            confirmButton: 'Request'
        });
    }

    #makeRequest(id) {
        let modalProperties = this.#bootstrapControl.getModalProperties(this.#modalId);

        modalProperties.loading = true;

        const { mutate: addRequestMutate } = useMutation(ADDREQUEST_MUTATION, {
            fetchPolicy: 'no-cache',
            variables: {
                id: id
            }
        });

        addRequestMutate()
            .then(result => {
                if(result.data.addRequest.success) {
                    this.#bootstrapControl.showToast("success", "Your request has been added to the queue");
                } else {
                    this.#bootstrapControl.showToast("danger", result.data.addRequest.message);
                }
            })
            .catch(error => {
                this.#bootstrapControl.showToast("danger", "Something went wrong while processing your request");
            })
            .finally(() => {
                this.#bootstrapControl.hideModal(this.#modalId);
                modalProperties.loading = false;
            });
    }

}

export const RequestManagerPlugin = {
    install: (app, _options) => {
        app.config.globalProperties.requestManager = new RequestManager(app.config.globalProperties.bootstrapControl);
    }
}
