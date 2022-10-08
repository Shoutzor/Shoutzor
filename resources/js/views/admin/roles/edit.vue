<template>
    <div class="row row-cards">
        <div v-if="isLoading" class="col-sm-12">
            <p>Loading role information</p>
            <div class="spinner-border" role="status"></div>
        </div>
        <div v-else class="col-sm-12">
            <h1 class="mb-4">Edit Role: {{ role.name }}</h1>

            <form action="#" method="post">
                <div class="form-group mb-3">
                    <label class="form-label">Name</label>
                    <div>
                        <input :disabled="role.protected"
                           :value="role.name"
                           autocomplete="off"
                           class="form-control"
                           placeholder="Role name" type="text" />
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Description</label>
                    <div>
                        <textarea :disabled="role.protected"
                              class="form-control"
                        >{{ role.description }}</textarea>
                        <small class="form-hint">
                            A description for the role, used for administrative purposes only.
                        </small>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-header">Permissions</div>
                    <div class="card-body">
                        <permission-list
                            :hasPermissions="role.permissions"
                            :permissions="allPermissions" />
                    </div>
                </div>
                <div class="form-footer mt-2">
                    <button class="btn btn-primary" type="button">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { LIST_PERMISSIONS_QUERY } from "@graphql/permissions";
import { GET_ROLE_QUERY } from "@graphql/roles";
import PermissionList from "@components/PermissionList";

export default {
    name: "admin-roles",
    components: {
        PermissionList
    },
    props: {
        roleId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            isLoading: true,
            error: false,
            role: null,
            permissions: [],
            allPermissions: []
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        async getData() {
            this.isLoading = true;
            this.error = false;

            // First fetch all the permissions
            await this.apollo.query({
                query: LIST_PERMISSIONS_QUERY
            })
            .then((result) => {
                this.allPermissions = result.data.permissions;
            })
            .catch((error) => {
                this.error = true;
                this.bootstrapControl.showToast("danger", "Could not load the permissions, error:" + error);
            });

            // Next fetch the role data
            await this.apollo.query({
                query: GET_ROLE_QUERY,
                variables: {
                    id: this.roleId
                }
            })
            .then((result) => {
                this.role = result.data.role;
            })
            .catch((error) => {
                this.error = true;
                this.bootstrapControl.showToast("danger", "Could not load the role, error:" + error);
            })
            .finally(() => {
                this.isLoading = false;
            });
        }
    }
};
</script>
