import {Model} from '@vuex-orm/core';
import User from "./User";

export default class Task extends Model {
    static entity = 'task'

    static fields() {
        return {
            user_id: this.number(null).nullable(),
            user: this.hasOne(User, 'id', 'user_id'),
            filename: this.string(''),
            size: this.number(0),
            status: this.number(0)
        }
    }
}
