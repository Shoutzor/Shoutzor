<template>
  <div class="list-item">
    <div>
      <input :checked="hasPermission" class="form-check-input" type="checkbox">
    </div>
    <div class="text-truncate">
      <span class="text-body d-block">{{ permission.name }}</span>
      <small class="d-block text-muted text-truncate mt-n1">{{ permission.description }}</small>
    </div>
  </div>
</template>

<script>
export default {
  props: ['permission', 'hasPermission']
}
</script>
