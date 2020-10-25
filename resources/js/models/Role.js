import { Model } from '@vuex-orm/core';
import Permission from "./Permission";
import RolePermission from "./RolePermission";


export default class Role extends Model {
    static entity = 'roles'

    static fields () {
        return {
            id: this.string(''),
            name: this.string(''),
            permissions: this.belongsToMany(Permission, RolePermission, 'role_id', 'permission_id')
        }
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
