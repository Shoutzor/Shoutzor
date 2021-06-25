<template>
  <div class="dropdown-menu dropdown-menu-right auth-dropdown">
    <login-form></login-form>

    <div class="dropdown-divider"></div>

    <button class="btn btn-secondary" type="button">Register</button>
  </div>
</template>

<script>
import LoginForm from "@js/components/login/LoginForm";

export default {
  name: 'headerTop',
  components: {LoginForm}
}
</script>

<style lang="scss">
.auth-dropdown {
  padding: 5px;

  button {
    width: 100%;
  }
}
</style>
