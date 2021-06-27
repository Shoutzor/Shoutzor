<template>
  <div class="card card-md">
    <div class="card-body text-center py-4 p-sm-4">
      <h1>Database Settings</h1>
      <p class="text-muted">Provide the configuration details for setting up the database connection</p>
    </div>

    <div class="hr-text hr-text-center hr-text-spaceless">Enter your configuration</div>

    <div class="p-3">
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
        <input :type="properties.type" :name="field" :value="properties.default" :placeholder="properties.default" class="form-control" />
      </div>
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
    updateButton: { type: Function }
  },

  data() {
    return {
      dbFields: [],
      dbType: 'mysql',
      isLoading: false
    };
  },

  computed: {
    activeDbFields: function() {
      return (this.dbType in this.dbFields) ? this.dbFields[this.dbType] : [];
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
    getFields() {
      this.isLoading = true;
      this.updateButtonLoading(true);

      axios.get('/installer/database/getFields').then(res => {
        this.dbFields = res.data;
      }).catch(err => {

      }).finally(() => {
        this.isLoading = false;
        this.updateButtonLoading(false);
      });
    },

    testSettings() {
      this.isLoading = true;
      this.updateButtonLoading(true);

      axios.post('/installer/database/configureDatabase', {
        formData: here
      }).then(res => {
        Package.insert(res);
      }).catch(err => {

      }).finally(() => {
        this.isLoading = false;
        this.updateButtonLoading(false);
      });
    },

    onButtonClick() {
      if(isLoading === false) {
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
