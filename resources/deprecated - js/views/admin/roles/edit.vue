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
                                <input :disabled="role.protected" :value="role.name" autocomplete="off"
                                       class="form-control"
                                       placeholder="Role name" type="text">
                                <small class="form-hint">The name of the role</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Role Description</label>
                            <div>
                                <textarea :disabled="role.protected" :value="role.description"
                                          class="form-control"></textarea>
                                <small class="form-hint">A description for the role, used for administrative purposes
                                    only.</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <permission-list
                                :hasPermissions="role.permissions"
                                :permissions="allPermissions"></permission-list>
                        </div>
                        <div class="form-footer">
                            <button class="btn btn-primary" type="button">Save</button>
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
import PermissionList from "../../../../components/PermissionList/PermissionList";

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
