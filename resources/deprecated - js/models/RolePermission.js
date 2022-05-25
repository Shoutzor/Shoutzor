import {Model} from '@vuex-orm/core';

export default class RolePermission extends Model {
    static entity = 'role_permission';

    static primaryKey = ['role_id', 'permission_id'];

    static fields() {
        return {
            role_id: this.number(null),
            permission_id: this.number(null)
        }
    }
}
