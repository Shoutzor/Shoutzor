<template>
    <div :class="classes" class="alert" role="alert">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'base-alert',

    props: {
        classes: {
            type: Array,
            required: false,
            default: []
        }
    }
};
</script>
