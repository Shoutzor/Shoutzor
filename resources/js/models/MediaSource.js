import {Model} from '@vuex-orm/core';

export default class MediaSource extends Model {
    static entity = 'mediasources'
    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/mediasource'
            }
        }
    }

    static fields() {
        return {
            id: this.number(null),
            identifier: this.string(''),
            name: this.string(null),
            icon: this.string('')
        }
    }
}
