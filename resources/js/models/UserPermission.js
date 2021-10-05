import {Model} from '@vuex-orm/core';

export default class UserPermission extends Model {
    static entity = 'user_permission'

    static primaryKey = ['user_id', 'permission_id'];

    static fields() {
        return {
            user_id: this.uid(null),
            permission_id: this.number(null)
        }
    }
}
