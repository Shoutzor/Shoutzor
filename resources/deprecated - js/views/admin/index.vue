<template>
  <div>
    <admin-menu></admin-menu>

    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: "admin-view"
};
</script>
