<template>
  <div class="card card-md">
    <div class="card-body text-center py-4 p-sm-4">
      <h1>Database Settings</h1>
      <p class="text-muted">Provide the configuration details for setting up the database connection</p>
    </div>

    <div v-if="hasConnection === false && isLoading === false">
      <div class="hr-text hr-text-center hr-text-spaceless pt-4 mb-2">Enter your configuration</div>

      <div class="p-3">
        <div v-if="hasMessages" class="alert alert-danger" role="alert">
          <h4 class="alert-title">An error has occurred</h4>
          <div v-for="message in messages" class="text-muted">{{ message }}</div>
        </div>

        <div>
          <div class="mb-3">
            <div class="form-label">Database Type</div>
            <select class="form-select" name="dbtype" v-model="dbType">
              <option value="mysql">MySQL</option>
              <option value="pgsql">PostgreSQL</option>
              <option value="sqlsrv">MSSQL</option>
            </select>
          </div>

          <div v-for="(properties, field) in activeDbFields" class="mb-3">
            <div class="form-label">{{ field | capitalize }}</div>
            <input
               v-model="dbFieldsData[field]"
               :type="properties.type"
               :name="field"
               :placeholder="properties.default"
               :class="(field in messages ? 'is-invalid' : '') + ' form-control'" />
          </div>
        </div>
      </div>
    </div>

    <div v-else-if="hasConnection === true" class="empty">
      <circle-check-icon class="empty-icon text-lime"></circle-check-icon>
      <p class="empty-title">Connection success</p>
    </div>

    <div v-else class="empty">
      <div class="spinner-border" role="status"></div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import axios from "axios";

export default {
  name: "installer-database-view",

  props: {
    showNextButton: { type: Function },
    updateButtonLoading: { type: Function },
    updateButtonText: { type: Function }
  },

  data() {
    return {
      dbFields: {},
      dbFieldsData: {},
      dbType: 'mysql',
      isLoading: false,
      hasConnection: false,
      hasValidated: false,
      messages: {}
    };
  },

  computed: {
    //Return the database fields to show, based on the selected database type dropdown
    activeDbFields: function() {
      return (this.dbType in this.dbFields) ? this.dbFields[this.dbType] : [];
    },

    //Check if there are any messages to display
    hasMessages: function() {
      return Object.keys(this.messages).length > 0;
    }
  },

  created() {
    Vue.bus.on('buttonClicked', this.onButtonClick);
  },

  mounted() {
    this.getFields()
    this.showNextButton(false);
    this.updateButtonText('Test settings');
  },

  methods: {
    //Fetch all database fields
    getFields() {
      this.isLoading = true;
      this.updateButtonLoading(true);
      this.dbFieldsData = {};

      axios.get('/installer/database/getFields').then(res => {
        this.dbFields = res.data;
      }).catch(err => {
        this.messages.general = err.response.status + ' - ' + err.response.statusText;
      }).finally(() => {
        this.isLoading = false;
        this.updateButtonLoading(false);
      });
    },

    //Test & save the configured DB settings
    testSettings() {
      this.isLoading = true;
      this.updateButtonLoading(true);
      this.hasConnection = false;
      this.messages = {};

      axios.post('/installer/database/configureDatabase', {
        dbtype: this.dbType,
        ...this.dbFieldsData
      }).then(res => {
        this.hasConnection = res.data.connection;
        this.messages = res.data.messages;
      }).catch(err => {
        this.messages.general = err.response.status + ' - ' + err.response.statusText;
      }).finally(() => {
        this.isLoading = false;
        this.updateButtonLoading(false);

        if(this.hasConnection) {
          this.showNextButton(true);
        } else {
          this.showNextButton(false);
        }
      });
    },

    onButtonClick() {
      if(this.isLoading === false) {
        this.testSettings();
      }
    }
  },

  filters: {
    capitalize: function (value) {
      if (!value) return ''
      value = value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1)
    }
  }
};
</script>

<style lang="scss" scoped>
.empty-icon {
  width: 5rem;
  height: 5rem;
}

.card-body {
  padding-bottom: 0 !important;
}
</style>
