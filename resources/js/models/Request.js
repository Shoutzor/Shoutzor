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
            media: this.belongsTo(Media, 'media_id'),
            user: this.belongsTo(User, 'user_id'),
            playtime: this.attr(null),
            requested_at: this.attr(null)
        }
    }

    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/request'
            }
        }
    }

/*    static afterWhere (requests) {
        requests.forEach((request) => {
           //Fetch dependencies
            console.log(request);
        });

        return requests;
    }*/
}
