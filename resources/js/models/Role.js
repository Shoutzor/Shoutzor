import { Model } from '@vuex-orm/core';
import Permission from "./Permission";
import RolePermission from "./RolePermission";


export default class Role extends Model {
    static entity = 'roles';
    static eagerLoad = ['permissions'];

    static fields () {
        return {
            id: this.number(null),
            name: this.string(''),
            permissions: this.belongsToMany(Permission, RolePermission, 'role_id', 'permission_id')
        }
    }

    /**
     * Checks if a role has the permission
     * @param permissionName
     */
    can(permissionName) {
        //Check permissions
        let check = this.permissions.some(function(p) {
            return p.name === permissionName;
        });

        return !!check;
    }

    static apiConfig = {
        actions: {
            fetchAll() {
                return this.get('/api/role/get')
            },
            fetchById(id) {
                return this.get('/api/role/get/${id}')
            },
            fetchForUser() {
                return this.get('/api/role/user')
            }
        }
    }
}
