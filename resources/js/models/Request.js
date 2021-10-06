import {Model} from '@vuex-orm/core';

import Media from "./Media";
import User from "./User";
import RequestUser from "./RequestUser";

export default class Request extends Model {
    static entity = 'requests'
    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/request'
            }
        }
    }

    static fields() {
        return {
            id: this.uid(null),
            media_id: this.uid(null),
            media: this.belongsTo(Media, 'media_id'),
            users: this.belongsToMany(User, RequestUser, 'request_id', 'user_id'),
            requested_at: this.attr(null),
            played_at: this.attr(null)
        }
    }
}
