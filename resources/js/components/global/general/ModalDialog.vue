<template>
    <div v-if="show" :class="'modal modal-blur fade show' + wrapperClass" role="dialog">
        <div :class="'modal-dialog ' + modalClass">
            <div :class="'modal-content ' + containerClass">
                <div v-if="hasStatus" :class="'modal-status' + statusClass"></div>
                <div v-if="hasHeader" :class="'modal-header' + headerClass">
                    <h5 class="modal-title">{{ title }}</h5>
                </div>
                <div :class="'modal-body ' + bodyClass">
                    <slot :data="data"></slot>
                </div>
                <div v-if="hasFooter" :class="'modal-footer' + footerClass">
                    <button
                        v-if="hasCancelButton"
                        v-on:click="onCancelButtonClick"
                        :class="'btn ' + cancelButtonClass"
                        type="button">{{ cancelButton }}
                    </button>
                    <button
                        v-if="hasConfirmButton"
                        v-on:click="onConfirmButtonClick"
                        :class="'btn ' + confirmButtonClass"
                        type="button">{{ confirmButton }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";

export default {
    props: {
        hasHeader: {
            type: Boolean,
            required: false,
            default: true
        },
        hasStatus: {
            type: Boolean,
            required: false,
            default: false
        },
        hasFooter: {
            type: Boolean,
            required: false,
            default: true
        },
        hasCancelButton: {
            type: Boolean,
            required: false,
            default: true
        },
        hasConfirmButton: {
            type: Boolean,
            required: false,
            default: true
        },
        wrapperClass: {
            type: String,
            required: false,
            default: ''
        },
        modalClass: {
            type: String,
            required: false,
            default: 'modal-dialog-centered'
        },
        containerClass: {
            type: String,
            required: false,
            default: ''
        },
        statusClass: {
            type: String,
            required: false,
            default: ''
        },
        headerClass: {
            type: String,
            required: false,
            default: ''
        },
        bodyClass: {
            type: String,
            required: false,
            default: ''
        },
        footerClass: {
            type: String,
            required: false,
            default: ''
        },
        cancelButtonClass: {
            type: String,
            required: false,
            default: 'me-auto'
        },
        confirmButtonClass: {
            type: String,
            required: false,
            default: 'btn-primary'
        },
        title: {
            type: String,
            required: false,
            default: ''
        },
        cancelButton: {
            type: String,
            required: false,
            default: 'Cancel'
        },
        confirmButton: {
            type: String,
            required: false,
            default: 'Confirm'
        }
    },

    data() {
        return {
            data: {},
            show: false
        }
    },

    methods: {
        onCancelButtonClick() {
            Vue.bus.emit('modal.cancel');
        },

        onConfirmButtonClick() {
            Vue.bus.emit('modal.confirm');
        },

        showModal(data = {}) {
            if(this.show === true) {
                throw "Tried showing a modal while a modal is already showing";
            }

            this.show = true;
        },

        hideModal() {
            this.show = false;
            this.data = {};
        }
    }
}
</script>

<style lang="scss">
.show {
    display: block;
}
</style>
