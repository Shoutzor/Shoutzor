<template>
  <div class="card card-sm">
    <div class="card-body d-flex">
      <StatusIcon
          v-if="status === 1"
          classes="bg-green-lt"
          iconName="check-icon"></StatusIcon>
      <StatusIcon
          v-else-if="status === 0"
          classes="bg-red-lt"
          iconName="alert-circle-icon"></StatusIcon>
      <StatusIcon
          v-else-if="running === true"
          classes="bg-azure-lt"
          iconClasses="rotate"
          iconName="circle-dotted-icon"></StatusIcon>
      <StatusIcon
          v-else
          classes="bg-azure-lt"
          iconName="clock-icon"></StatusIcon>

      <div class="ms-3 w-100">
        <div class="strong">{{ name }}</div>
        <div class="pre-text">{{ description }}</div>

        <div v-if="status === 0" class="alert alert-danger mt-1 w-100">
          <h4 class="alert-title">An error occured</h4>
          <div class="text-muted">{{ error }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import StatusIcon from "@js/components/global/status/StatusIcon";

export default {
  components: {StatusIcon},
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
    running: {
      type: Boolean,
      required: false,
      default: false
    },
    error: {
      type: String,
      required: false,
      default: ''
    }
  }
}
</script>

<style lang="scss">
.pre-text {
  white-space: pre-wrap;
}

.rotate {
  -webkit-animation: 2.0s linear infinite spinner-border;
  animation: 2.0s linear infinite spinner-border;
}
</style>
