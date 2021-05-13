import {Model} from '@vuex-orm/core';
import Permission from "./Permission";
import Role from "./Role";
import UserPermission from "./UserPermission";
import UserRole from "./UserRole";

export default class User extends Model {
    static entity = 'users';
    static apiConfig = {
        actions: {
            fetchCurrent() {
                return this.get('/api/role/get')
            }, fetchById(id) {
                return this.get('/api/role/get/${id}')
            }, fetchForUser() {
                return this.get('/api/role/user')
            }
        }
    }

    static fields() {
        return {
            id: this.uid(),
            username: this.string(''),
            email: this.string(''),
            email_verified_at: this.attr(null).nullable(),
            permissions: this.belongsToMany(Permission, UserPermission, 'user_id', 'permission_id'),
            roles: this.belongsToMany(Role, UserRole, 'user_id', 'role_id')
        }
    }

    /**
     * Checks if a user has the permission
     * @param permissionName
     */
    can(permissionName) {
        //Check permissions
        let check = this.permissions.some(function(p) {
            return p.name === permissionName;
        });

        if(check) {
            return true;
        }

        //Check roles
        check = this.roles.some(function(role) {
            return role.can(permissionName);
        });

        return !!check;
    }
}
