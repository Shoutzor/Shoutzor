<template>
  <span :class="classes + ' avatar'">
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