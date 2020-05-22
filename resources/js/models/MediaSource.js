import { Model } from '@vuex-orm/core';

import Media from "./Media";

export default class MediaSource extends Model {
    static entity = 'mediasources'

    static fields () {
        return {
            id: this.uid(),
            name: this.string(''),
            icon: this.attr([]),
            media: this.hasMany(Media, 'source_id', 'id')
        }
    }
}
