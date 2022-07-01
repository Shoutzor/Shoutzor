<template>
    <div :id="id" :class="classes" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div v-if="hasHeader" class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                </div>
                <div class="modal-body">
                    <template v-if="loading">
                        <div class="text-center">
                            <base-spinner />
                        </div>
                    </template>
                    <slot v-else></slot>
                </div>
                <div v-if="hasFooter" class="modal-footer">
                    <base-button
                        v-if="hasCancelButton"
                        @click="onCancel"
                        :disabled="loading"
                        class="btn btn-secondary me-auto"
                        data-bs-dismiss="modal">
                        {{ cancelButton }}
                    </base-button>
                    <base-button
                        v-if="hasConfirmButton"
                        @click="onConfirm"
                        :disabled="loading"
                        class="btn btn-primary">
                        <template v-if="loading">
                            <base-spinner />
                        </template>
                        <template v-else>{{ confirmButton }}</template>
                    </base-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "./BaseModal.scss";

import {computed, reactive} from "vue";
import BaseButton from "@components/BaseButton";
import BaseSpinner from "@components/BaseSpinner";

export default {
    name: 'base-modal',

    components: {
        BaseSpinner,
        BaseButton
    },

    props: {
        id: {
            type: String,
            required: true
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
        },
        show: {
            type: Boolean,
            required: false,
            default: false
        },
        hasHeader: {
            type: Boolean,
            required: false,
            default: true
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
        onConfirm: {
            type: Function,
            required: true
        },
        onCancel: {
            type: Function,
            required: true
        },
        loading: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    setup(props) {
        props = reactive(props);

        return {
            classes: computed(() => ({
                'modal': true,
                'modal-blur': true,
                'fade': true,
                'show': props.show
            }))
        }
    }
}
</script>
