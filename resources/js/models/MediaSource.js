import { Model } from '@vuex-orm/core';

import Media from "./Media";

export default class MediaSource extends Model {
    static entity = 'mediasources'

    static fields () {
        return {
            name: this.string(''),
            icon: this.attr([])
        }
    }
}
