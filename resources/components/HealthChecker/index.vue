<template>
    <div>
        <div v-if="showHeader" class="d-flex justify-content-end">
            <h3 v-if="showTitle">{{ headerTitle }}</h3>

            <div v-if="showRefreshButton" class="btn btn-secondary ms-2 mb-2" @click="onRefreshButtonClick">
                <span v-if="refreshButtonText" class="refreshText me-1">{{ refreshButtonText }}</span>
                <b-icon-arrow-counterclockwise v-if="isLoading === false" class="refreshIcon ms-1"></b-icon-arrow-counterclockwise>
                <div v-else class="spinner-border spinner-border-sm" role="status"></div>
            </div>

            <button v-if="showRepairButton" class="btn btn-primary ms-2 mb-2" @click="onRepairButtonClick">
                Attempt automatic repair
            </button>
        </div>

        <div v-if="repairResult" class="mb-2">
            <div class="card">
                <div v-if="repairResult.result === false" class="card-status-start bg-danger"></div>
                <div v-else class="card-status-start bg-success"></div>
                <div class="card-body">
                    <h3 class="card-title">Automatic repair result(s)</h3>
                    <p v-if="repairResult.result === false">A failure occurred while requesting the automatic repair</p>
                    <template v-else>
                        <p v-for="result in repairResult.data" class="repair-result">
                            <strong>{{ result.name }}:</strong> <span class="text-prewrap">{{ result.result }}</span>
                        </p>
                    </template>
                </div>
            </div>
        </div>

        <div v-if="isLoading" class="card card-sm rounded-0">
            <div class="card-body">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>

        <template v-else-if="healthChecks.length > 0">
            <health-status
                v-for="check in healthChecks"
                v-bind:key="check.name"
                v-bind="check">
            </health-status>
        </template>

        <div v-else class="card card-sm rounded-0">
            <div class="card-body">
                No health checks found
            </div>
        </div>
    </div>
</template>

<script>
import {reactive} from "vue";
import HealthStatus from "@components/HealthStatus";

export default {
    name: 'health-checker',

    components: { HealthStatus },

    props: {
        healthChecks: {
            type: Array,
            required: true,
            default: null
        },
        repairResult: {
            type: Object,
            required: false,
            default: null
        },
        showHeader: {
            type: Boolean,
            required: false,
            default: true
        },
        showTitle: {
            type: Boolean,
            required: false,
            default: true
        },
        headerTitle: {
            type: String,
            required: false,
            default: 'Health Check'
        },
        showRefreshButton: {
            type: Boolean,
            required: false,
            default: true
        },
        refreshButtonText: {
            type: String,
            required: false,
            default: 'Refresh'
        },
        showRepairButton: {
            type: Boolean,
            required: false,
            default: true
        },
        isLoading: {
            type: Boolean,
            required: false,
            default: false
        }
    },

    emits: ['refreshButtonClick', 'repairButtonClick'],

    setup(props, { emit }) {
        props = reactive(props);

        return {
            onRefreshButtonClick() {
                emit('refreshButtonClick');
            },
            onRepairButtonClick() {
                emit('repairButtonClick')
            }
        }
    }
}
</script>
