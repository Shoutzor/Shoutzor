import { Model } from '@vuex-orm/core';


export default class Permission extends Model {
    static entity = 'permission'

    static fields () {
        return {
            id: this.string(''),
            name: this.string(''),
            description: this.string('')
        }
    }

    static apiConfig = {
        actions: {
            fetchAll() {
                return this.get('/api/permission/get')
            },
            fetchById(id) {
                return this.get('/api/permission/get/${id}')
            },
            fetchForUser() {
                return this.get('/api/permission/user')
            }
        }
    }
}
