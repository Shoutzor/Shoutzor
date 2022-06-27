import { reactive } from "vue";
import { Toast } from "bootstrap";

class BootstrapControl {

    #state
    #bsToastOptions

    #counter

    constructor() {
        this.#state = reactive({
            toasts: []
        });

        this.#bsToastOptions = {
            animation: true,
            autohide: true,
            delay: 5000
        };

        this.#counter = 0;
    }

    get toasts() {
        return this.#state.toasts;
    }

    showToast(type, message) {
        this.#counter += 1;
        let id = "toast" + this.#counter;

        this.#state.toasts.push({
            id,
            type,
            message
        });

        setTimeout(() => {
            let toastEl = document.querySelector('#'+id);

            (new Toast(toastEl, this.#bsToastOptions)).show();

            toastEl.addEventListener('hidden.bs.toast', () => {
                this.#removeToast(id);
            });
        }, 100);
    }

    #removeToast(id) {
        this.#state.toasts = this.#state.toasts.filter((toast) => {
            return toast.id !== id;
        });
    }
}

export const BootstrapControlPlugin = {
    install: (app, _options) => {
        app.config.globalProperties.bootstrapControl = new BootstrapControl();
    }
}
