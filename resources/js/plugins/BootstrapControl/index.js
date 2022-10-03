import { nextTick, reactive } from "vue";
import { Modal, Toast } from "bootstrap";

class BootstrapControl {

    #state
    #modalInstances
    #bsToastOptions

    #toastCounter
    #modalCounter

    constructor() {
        this.#state = reactive({
            toasts: [],
            modals: []
        });

        this.#modalInstances = {};

        this.#bsToastOptions = {
            animation: true,
            autohide: true,
            delay: 2500
        };

        this.#toastCounter = 0;
        this.#modalCounter = 0;
    }

    get toasts() {
        return this.#state.toasts;
    }

    get modals() {
        return this.#state.modals;
    }

    /**
     * Returns the bootstrap Modal instance for the provided ID
     * @param id
     * @returns {*}
     */
    getBsModal(id) {
        return this.#modalInstances[id];
    }

    /**
     * Returns the properties currently used by the Component representing the modal
     * you can make live changes to the rendering by editing these properties.
     * @param id
     * @returns {T}
     */
    getModalProperties(id) {
        let modal = this.#state.modals.find((modal) => {
            return modal.id === id;
        });

        return modal ? modal.options : null;
    }

    showToast(type, message) {
        this.#toastCounter += 1;
        let id = "toast" + this.#toastCounter;

        this.#state.toasts.push({
            id,
            type,
            message
        });

        // Wait for DOM to add the toast before interacting with it
        nextTick().then(() => {
            let toastEl = document.querySelector('#'+id);

            (new Toast(toastEl, this.#bsToastOptions)).show();

            toastEl.addEventListener('hidden.bs.toast', () => {
                this.#removeToast(id);
            });
        });
    }

    #removeToast(id) {
        this.#state.toasts = this.#state.toasts.filter((toast) => {
            return toast.id !== id;
        });
    }

    showModal(options) {
        let defaultOptions = {
            onConfirm: () => {},
            onCancel: () => {},
            title: '',
            body: '',
            hasHeader: false,
            hasFooter: true,
            hasConfirmButton: true,
            hasCancelButton: true,
            confirmButton: 'Confirm',
            cancelButton: 'Cancel',
            loading: false
        };

        // Override defaultOptions with any optionally provided options
        options = {
            ...defaultOptions,
            ...options
        };

        // Generate the unique ID for the modal
        this.#modalCounter += 1;
        let id = "modal" + this.#modalCounter;

        this.#state.modals.push({
            id,
            options
        });

        // Wait for DOM to add the modal before interacting with it
        nextTick().then(() => {
            let modalEl = document.querySelector('#'+id);

            this.#modalInstances[id] = new Modal(modalEl);
            this.#modalInstances[id].show();

            modalEl.addEventListener('hidden.bs.modal', () => {
                this.#removeModal(id);
            });
        });

        return id;
    }

    hideModal(id) {
        this.#modalInstances[id].hide();
    }

    #removeModal(id) {
        delete this.#modalInstances[id];
        this.#state.modals = this.#state.modals.filter((modal) => {
            return modal.id !== id;
        });
    }
}

export const BootstrapControlPlugin = {
    install: (app, _options) => {
        app.config.globalProperties.bootstrapControl = new BootstrapControl();
    }
}
