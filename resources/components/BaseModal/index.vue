<template>
    <div :id="id" :class="classes" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div v-if="hasHeader" class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div v-if="hasFooter" class="modal-footer">
                    <base-button
                        v-if="hasCancelButton"
                        @click="onCancelClick"
                        class="btn btn-secondary me-auto">
                        {{ cancelButton }}
                    </base-button>
                    <base-button
                        v-if="hasConfirmButton"
                        @click="onConfirmClick"
                        class="btn btn-primary">
                        {{ confirmButton }}
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

export default {
    name: 'base-modal',

    components: {
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
        }
    },

    emits: ['cancelClick', 'confirmClick'],

    setup(props, { emit }) {
        props = reactive(props);

        return {
            onCancelClick() {
                emit('cancelClick', props.id);
            },
            onConfirmClick() {
                emit('confirmClick', props.id);
            },
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
