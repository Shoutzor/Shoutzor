<template>
    <div :id="id" :class="classes" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div v-if="hasStatus" class="modal-status" :class="statusClass"></div>
                <div v-if="hasHeader" class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                </div>
                <div class="modal-body">
                    <slot :data="data"></slot>
                </div>
                <div v-if="hasFooter" class="modal-footer">
                    <base-button
                        v-if="hasCancelButton"
                        @click="onCancelClick"
                        :classes="cancelButtonClass">
                        {{ cancelButton }}
                    </base-button>
                    <base-button
                        v-if="hasConfirmButton"
                        @click="onConfirmClick"
                        :classes="confirmButtonClass">
                        {{ confirmButton }}
                    </base-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BaseButton from "@components/BaseButton";
import {computed, reactive} from "vue/dist/vue";

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
        statusClass: {
            type: Array,
            required: false,
            default: []
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
            show: true
        }
    },

    emits: ['cancelClick', 'confirmClick'],

    setup(props, { emit }) {
        props = reactive(props);

        return {
            onCancelClick() {
                this.show = false;
                emit('cancelClick', props.id);
            },
            onConfirmClick() {
                this.show = false;
                emit('confirmClick', props.id);
            },
            classes: computed(() => ({
                'modal': true,
                'modal-blur': true,
                'fade': true,
                'show': this.show
            }))
        }
    }
}
</script>
