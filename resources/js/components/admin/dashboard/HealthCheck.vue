<template>
    <div>
        <div class="d-flex align-items-center">
            <h3>Health Check</h3>
            <refresh-icon v-if="isLoading()" class="ms-2" @click="onRefreshButtonClick()"></refresh-icon>
            <div v-else class="spinner-border spinner-border-sm ms-2" role="status"></div>
            <button v-if="needsFixing()"
                    @click="onRepairButtonClick()"
                    class="btn btn-pill btn-sm ms-2">Attempt automatic repair</button>
        </div>

        <div v-if="needsFixing() && repairResult !== ''" class="mb-2">
            <div class="card">
                <div v-if="repairError" class="card-status-start bg-danger"></div>
                <div v-else class="card-status-start bg-green"></div>
                <div class="card-body">
                    <h3 class="card-title">Automatic repair</h3>
                    <p>{{ repairResult }}</p>
                </div>
            </div>
        </div>

        <div class="card card-sm" v-if="loading">
            <div class="card-body">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>

        <div
            v-else-if="healthData && Object.keys(healthData).length > 0"
            v-for="(check, name) in healthData"
            class="card card-sm">
            <div class="card-body d-flex">
                <span
                    v-if="check.healthy === true"
                    class="avatar healthStatus bg-green-lt"
                >
                    <check-icon class="healthStatus-icon"></check-icon>
                </span>
                <span
                    v-else
                    class="avatar healthStatus bg-red-lt"
                >
                    <alert-circle-icon class="healthStatus-icon"></alert-circle-icon>
                </span>

                <div class="ms-3">
                    <div class="strong">{{ name }}</div>
                    <div>{{ check.status }}</div>
                </div>
            </div>
        </div>

        <div class="card card-sm" v-else>
            <div class="card-body">
                No health checks found
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            healthData: {},
            loading: true,
            errored: false,
            repairLoading: false,
            repairError: false,
            repairResult: ''
        };
    },

    mounted() {
        this.doHealthCheck();
    },

    methods: {
        resetVariables() {
            this.healthData = {};
            this.loading = false;
            this.errored = false;
            this.repairLoading = false;
            this.repairError = false;
            this.repairResult = '';
        },

        isLoading() {
            return !this.loading;
        },

        needsFixing() {
            let result = false;

            Object.values(this.healthData).forEach(async function(item) {
                if(item.healthy === false) {
                    result = true;
                }
            });

            return result;
        },

        onRefreshButtonClick() {
            this.resetVariables();
            this.loading = true;
            this.doHealthCheck();
        },

        onRepairButtonClick() {
            this.resetVariables();
            this.loading = true;
            this.repairLoading = true;
            this.attemptRepair();
        },

        doHealthCheck() {
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
            axios.get('/api/dashboard/fixhealth')
                .then(response => {
                    this.repairResult = response.data.message;
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

<style lang="scss">

</style>
