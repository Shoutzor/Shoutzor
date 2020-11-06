<template>
    <div class="row row-cards">
        <div v-if="role" class="col-sm-12">
            <h1 class="mb-4">Edit Role: {{ role.name }}</h1>

            <div class="card">
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="form-group mb-3">
                            <label class="form-label">Role name</label>
                            <div>
                                <input type="text" class="form-control" placeholder="Role name" autocomplete="off" :value="role.name" :disabled="role.protected">
                                <small class="form-hint">The name of the role</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Role Description</label>
                            <div>
                                <textarea class="form-control" :value="role.description" :disabled="role.protected"></textarea>
                                <small class="form-hint">A description for the role, used for administrative purposes only.</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <permission-list
                                :permissions="allPermissions"
                                :hasPermissions="role.permissions"></permission-list>
                        </div>
                        <div class="form-footer">
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-else class="col-sm-12">
            <p>Loading role information</p>
            <div class="spinner-border" role="status"></div>
        </div>
    </div>
</template>

<script>
import Role from "@js/models/Role";
import Permission from "@js/models/Permission";
import PermissionList from "../../../components/admin/permissions/PermissionList";

export default {
    name: "admin-roles",
    components: {PermissionList},
    props: {
        roleId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            role: null,
            allPermissions: null
        }
    },
    created() {
        this.role = Role.query().with('permissions').whereId(this.roleId).first();
        this.allPermissions = Permission.all();
    }
};
</script>
