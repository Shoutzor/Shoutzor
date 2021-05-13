import {Model} from '@vuex-orm/core';

export default class Package extends Model {
    static entity = 'packages'
    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/package'
            }
        }
    }

    static fields() {
        return {
            id: this.string(''),
            icon: this.string(''),
            name: this.string(''),
            author: this.string(''),
            website: this.string(''),
            description: this.string(''),
            version: this.string(''),
            license: this.string(''),
            enabled: this.boolean(false)
        }
    }
}
