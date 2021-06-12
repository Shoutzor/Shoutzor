<template>
    <div>
        <div class="d-flex align-items-center" v-if="showHeader">
            <h3 v-if="showTitle">Health Check</h3>

            <div v-if="enableRefreshButton"
                 class="ms-2 refreshButton"
                 :class="refreshButtonClasses"
                 @click="onRefreshButtonClick()"
            >
                <span v-if="refreshButtonText !== ''" class="refreshText">{{ refreshButtonText }}</span>
                <refresh-icon v-if="isLoading()" class="refreshIcon sm-2"></refresh-icon>
                <div v-else class="spinner-border spinner-border-sm ms-2" role="status"></div>
            </div>

            <button v-if="needsFixing() && enableAutofix"
                    @click="onRepairButtonClick()"
                    class="autoFixButton btn btn-pill btn-sm ms-2">Attempt automatic repair</button>
        </div>

        <div v-if="repairError || Object.keys(repairResult).length > 0" class="mb-2">
            <div class="card">
                <div v-if="repairError || repairResult.result === false" class="card-status-start bg-danger"></div>
                <div v-else class="card-status-start bg-green"></div>
                <div class="card-body">
                    <h3 class="card-title">Automatic repair result(s)</h3>
                    <p v-if="repairError">A failure occured while requesting the automatic repair</p>
                    <p v-else v-for="result in repairResult.data" class="repair-result"><strong>{{ result.name }}:</strong> <span class="pre-text">{{ result.result }}</span></p>
                </div>
            </div>
        </div>

        <div class="card card-sm" v-if="loading">
            <div class="card-body">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>

        <health-status
            v-else-if="healthData && healthData.length > 0"
            v-for="check in healthData"
            v-bind:key="check.name"
            v-bind:data="check"
            v-bind="check">
        </health-status>

        <div class="card card-sm" v-else>
            <div class="card-body">
                No health checks found
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import HealthStatus from "@js/components/HealthCheck/HealthStatus";

export default {
    components: {HealthStatus},

    props: {
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
        enableRefreshButton: {
            type: Boolean,
            required: false,
            default: true
        },
        refreshButtonClasses: {
            type: String,
            required: false,
            default: ''
        },
        refreshButtonText: {
            type: String,
            required: false,
            default: ''
        },
        enableAutofix: {
            type: Boolean,
            required: false,
            default: true
        }
    },

    data() {
        return {
            healthData: [],
            loading: true,
            errored: false,
            repairLoading: false,
            repairError: false,
            repairResult: []
        };
    },

    mounted() {
        this.doHealthCheck();
    },

    methods: {
        resetVariables() {
            this.healthData = [];
            this.loading = false;
            this.errored = false;
            this.repairLoading = false;
            this.repairError = false;
            this.repairResult = [];
        },

        isLoading() {
            return !this.loading;
        },

        needsFixing() {
            let result = false;

            this.healthData.forEach(async function(item) {
                if(item.healthy === false) {
                    result = true;
                }
            });

            return result;
        },

        onRefreshButtonClick() {
            this.resetVariables();
            this.doHealthCheck();
        },

        onRepairButtonClick() {
            this.resetVariables();
            this.loading = true;
            this.attemptRepair();
        },

        doHealthCheck() {
            this.loading = true;
            axios.get('/api/dashboard/healthcheck')
                .then(response => {
                    this.healthData = response.data;
                })
                .catch(err => {
                    this.errored = true;
                })
                .finally(() => {
                    this.loading = false;
                })
        },

        attemptRepair() {
            this.repairLoading = true;
            axios.get('/api/dashboard/fixhealth')
                .then(response => {
                    this.repairResult = response.data;
                    this.doHealthCheck();
                })
                .catch(err => {
                    this.repairError = true;
                })
                .finally(() => {
                    this.repairLoading = false;
                })
        }
    }
}
</script>

<style lang="scss" scoped>
.pre-text {
    white-space: pre-wrap;
}

.refreshButton {
    margin-bottom: 6px;
}

.refreshIcon {
    margin: 0 0 0 5px;
}

.autoFixButton {
    margin-bottom: 6px;
}
</style>
