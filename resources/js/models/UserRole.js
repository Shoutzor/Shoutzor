import {Model} from '@vuex-orm/core';

export default class UserRole extends Model {
    static entity = 'user_role'

    static primaryKey = ['user_id', 'role_id'];

    static fields() {
        return {
            user_id: this.number(null),
            role_id: this.number(null)
        }
    }
}
