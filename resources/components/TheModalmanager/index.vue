<template>
    <div id="modal-container" class="modal-container position-absolute bottom-0 end-0">
        <base-modal
            v-for="modal in modals"
            :key="modal.id"
            :id="modal.id"
            v-bind="modal.options">
            {{ modal.options.body }}
        </base-modal>
    </div>
</template>

<script>
import BaseModal from "@components/BaseModal";

export default {
    name: 'the-modalmanager',

    components: {
        BaseModal
    },

    computed: {
        modals() {
            return this.bootstrapControl.modals;
        }
    }
}
</script>
