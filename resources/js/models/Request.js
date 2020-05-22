import { Model } from '@vuex-orm/core';

import Media from "./Media";
import User from "./User";

export default class Request extends Model {
    static entity = 'requests'

    static fields () {
        return {
            id: this.number(null),
            media_id: this.number(null),
            user_id: this.number(null).nullable(),
            media: this.hasOne(Media, 'id', 'media_id'),
            user: this.belongsTo(User, 'id', 'user_id'),
            playtime: this.attr(null),
            requested_at: this.attr(null)
        }
    }
}
