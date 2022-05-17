<template>
  <span class="statusIcon avatar" :class="classes">
    <component :is="iconName" :class="iconClasses"></component>
  </span>
</template>

<script>
import 'bootstrap-icons-vue';

export default {
    props: {
        iconName: {
            Type: String,
            required: true
        },
        classes: {
            Type: Array,
            required: false,
            default: []
        },
        iconClasses: {
            Type: Array,
            required: false,
            default: []
        }
    }
}
</script>
