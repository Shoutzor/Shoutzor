<template>
    <div id="toast-container" class="toast-container position-absolute bottom-0 end-0 p-3">
        <base-toast v-for="toast in toasts"
                    :key="toast.id"
                    :id="toast.id"
                    :type="toast.type">
            {{ toast.message }}
        </base-toast>
    </div>
</template>

<script>
import BaseToast from "@components/BaseToast";

export default {
    name: 'the-toastmanager',

    components: {
        BaseToast
    },

    computed: {
        toasts() {
            return this.bootstrapControl.toasts;
        }
    }
}
</script>
