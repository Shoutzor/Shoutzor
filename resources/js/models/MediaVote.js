import {Model} from '@vuex-orm/core';

import Media from "./Media";

export default class MediaVote extends Model {
    static entity = 'mediavote'

    static primaryKey = 'media_id'

    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/vote/count'
            }
        }
    }

    static fields() {
        return {
            id: this.number(null),
            media_id: this.number(null),
            media: this.belongsTo(Media, 'media_id'),
            count: this.number(null)
        }
    }
}
