import { Model } from '@vuex-orm/core';


export default class Permission extends Model {
    static entity = 'permission'

    static fields () {
        return {
            id: this.string(''),
            name: this.string(''),
            description: this.string(''),
            enabled: this.boolean(false)
        }
    }
}
