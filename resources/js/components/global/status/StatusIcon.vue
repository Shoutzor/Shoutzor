<template>
  <span class="statusIcon avatar" :class="classes">
    <component :is="iconName" :class="iconClasses"></component>
  </span>
</template>

<script>
export default {
    props: {
        iconName: {
            Type: String,
            required: true
        },
        classes: {
            Type: String,
            required: false,
            default: ''
        },
        iconClasses: {
            Type: String,
            required: false,
            default: ''
        }
    }
}
</script>