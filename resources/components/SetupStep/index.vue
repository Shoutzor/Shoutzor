<template>
    <div class="card card-sm rounded-0">
        <div class="card-body d-flex">
            <StatusIcon
                :class="statusIconClass"
                :iconName="statusIconName"
                :iconClasses="statusIconIconClasses"></StatusIcon>

            <div class="ms-3 w-100">
                <div class="strong">{{ name }}</div>
                <div class="text-prewrap">{{ description }}</div>

                <base-alert v-if="status === 0" :classes="['alert-danger', 'mt-1', 'w-100']">
                    <p><strong>An error occured:</strong></p>
                    {{ error }}
                </base-alert>
            </div>
        </div>
    </div>
</template>

<script>
import BaseAlert from "@components/BaseAlert";
import StatusIcon from "@components/StatusIcon";
import {computed, reactive} from "vue";

export default {
    name: "setup-step",

    components: {
        BaseAlert,
        StatusIcon
    },

    props: {
        name: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: false,
            default: ''
        },
        status: {
            type: Number,
            required: false,
            default: -1
        },
        isLoading: {
            type: Boolean,
            required: false,
            default: false
        },
        error: {
            type: String,
            required: false,
            default: ''
        }
    },

    setup(props) {
        props = reactive(props);
        return {
            statusIconName: computed(() => {
                if(props.status === 0) {
                    return 'b-icon-exclamation-circle';
                }
                else if(props.status === 1) {
                    return 'b-icon-check2';
                }
                else if(props.isLoading) {
                    return 'b-icon-gear';
                } else {
                    return 'b-icon-clock';
                }
            }),
            statusIconClass: computed(() => ({
                'text-white': true,
                'bg-success': props.status === 1,
                'bg-danger': props.status === 0,
                'bg-azure': props.status === -1 || props.isLoading
            })),
            statusIconIconClasses: computed(() => ({
                'rotate': props.isLoading
            })),
        }
    }
}
</script>
