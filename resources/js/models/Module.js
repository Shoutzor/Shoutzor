import {Model} from '@vuex-orm/core';

export default class Module extends Model {
    static entity = 'modules'
    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/modules'
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
