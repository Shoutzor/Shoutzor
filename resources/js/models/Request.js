import { Model } from '@vuex-orm/core';

import Media from "./Media";
import User from "./User";

export default class Request extends Model {
    static entity = 'requests'

    static fields () {
        return {
            id: this.uid(),
            media_id: this.number(0),
            user_id: this.number(null).nullable(),
            media: this.hasOne(Media, 'id', 'media_id'),
            user: this.hasOne(User, 'id', 'user_id'),
            requested_at: this.attr()
        }
    }
}
