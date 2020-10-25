import { Model } from '@vuex-orm/core';


export default class Role extends Model {
    static entity = 'roles'

    static fields () {
        return {
            id: this.string(''),
            name: this.string('')
        }
    }

    static apiConfig = {
        actions: {
            fetchAll() {
                return this.get('/api/role/get')
            },
            fetchById(id) {
                return this.get('/api/role/get/${id}')
            },
            fetchForUser() {
                return this.get('/api/role/user')
            }
        }
    }
}
