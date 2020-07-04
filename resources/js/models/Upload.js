import { Model } from '@vuex-orm/core';

import Media from "./Media";
import User from "./User";

export default class Upload extends Model {
    static entity = 'upload'

    static fields () {
        return {
            user_id: this.number(null).nullable(),
            user: this.hasOne(User, 'id', 'user_id'),
            filename: this.string(''),
            size: this.number(0),
            status: this.number(0)
        }
    }
}
