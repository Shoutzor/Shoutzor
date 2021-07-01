<template>
  <div>
    <div v-if="showHeader" class="d-flex align-items-center">
      <h3 v-if="showTitle">Health Check</h3>

      <div v-if="enableRefreshButton"
           :class="refreshButtonClasses"
           class="ms-2 refreshButton"
           @click="onRefreshButtonClick()"
      >
        <span v-if="refreshButtonText !== ''" class="refreshText">{{ refreshButtonText }}</span>
        <refresh-icon v-if="isLoading()" class="refreshIcon sm-2"></refresh-icon>
        <div v-else class="spinner-border spinner-border-sm ms-2" role="status"></div>
      </div>

      <button v-if="needsFixing() && enableAutofix"
              :class="autoFixButtonClasses"
              class="autoFixButton ms-2"
              @click="onRepairButtonClick()">Attempt automatic repair
      </button>
    </div>

    <div v-if="repairError || Object.keys(repairResult).length > 0" class="mb-2">
      <div class="card">
        <div v-if="repairError || repairResult.result === false" class="card-status-start bg-danger"></div>
        <div v-else class="card-status-start bg-green"></div>
        <div class="card-body">
          <h3 class="card-title">Automatic repair result(s)</h3>
          <p v-if="repairError">A failure occurred while requesting the automatic repair</p>
          <p v-for="result in repairResult.data" v-else class="repair-result"><strong>{{ result.name }}:</strong> <span
              class="pre-text">{{ result.result }}</span></p>
        </div>
      </div>
    </div>

    <div v-if="loading" class="card card-sm">
      <div class="card-body">
        <div class="spinner-border" role="status"></div>
      </div>
    </div>

    <health-status
        v-for="check in healthData"
        v-else-if="healthData && healthData.length > 0"
        v-bind:key="check.name"
        v-bind="check">
    </health-status>

    <div v-else class="card card-sm">
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
    isAllHealthy: {
      type: Function,
      required: false,
      default: (isAllHealthy) => {}
    },
    showInstallSteps: {
      type: Boolean,
      required: false,
      default: false
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
    },
    autoFixButtonClasses: {
      type: String,
      required: false,
      default: 'btn btn-pill btn-sm'
    }
  },

  data() {
    return {
      healthData: [],
      loading: true,
      errored: false,
      repairLoading: false,
      repairError: false,
      repairResult: [],
      isInitialized: false
    };
  },

  mounted() {
    this.doHealthCheck();
  },

  watch: {
    healthData: function(val) {
      if(this.isInitialized === false || this.errored === true) {
        this.isAllHealthy(false);
      } else {
        this.isAllHealthy(!this.needsFixing());
      }
    }
  },

  methods: {
    resetVariables() {
      this.healthData = [];
      this.loading = false;
      this.errored = false;
      this.repairLoading = false;
      this.repairError = false;
      this.repairResult = [];
      this.isInitialized = false;
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
      this.isAllHealthy(false);

      axios.get('/api/system/health', {params: {showInstallSteps: this.showInstallSteps}})
          .then(response => {
            this.healthData = response.data;
            this.isInitialized = true;
          })
          .catch(err => {
            this.errored = true;
          })
          .finally(() => {
            this.loading = false;
          });
    },

    attemptRepair() {
      this.repairLoading = true;
      axios.post('/api/system/health/fix', {showInstallSteps: this.showInstallSteps})
          .then(response => {
            this.repairResult = response.data;
            this.doHealthCheck();
          })
          .catch(err => {
            this.repairError = true;
          })
          .finally(() => {
            this.repairLoading = false;
          });
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
