import {Model} from '@vuex-orm/core';

export default class RequestUser extends Model {
    static entity = 'requests_user'

    static primaryKey = ['request_id', 'user_id'];

    static fields() {
        return {
            request_id: this.uid(null),
            user_id: this.uid(null)
        }
    }
}
