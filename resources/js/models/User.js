import { Model } from '@vuex-orm/core';

export default class User extends Model {
    static entity = 'users';

    static fields () {
        return {
            id: this.uid(),
            name: this.string(''),
            email: this.string(''),
            email_verified_at: this.attr(null).nullable()
        }
    }
}
