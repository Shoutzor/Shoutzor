<template>
  <div class="row row-cards">
    <div class="col-sm-12">
      <h1 class="mb-4">Manage Roles</h1>
      <role-list :roles="roles"></role-list>
    </div>
  </div>
</template>

<script>
import RoleList from "@js/components/admin/roles/RoleList";
import Role from "@js/models/Role";

export default {
  name: "admin-roles",
  components: {
    RoleList
  },
  computed: {
    roles: () => Role.all()
  }

};
</script>
