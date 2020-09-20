import { Model } from '@vuex-orm/core';

import Media from "./Media";
import User from "./User";

export default class Request extends Model {
    static entity = 'requests'

    static fields () {
        return {
            name: this.string(''),
            description: this.string(''),
            version: this.string(''),
            license: this.string(''),
            enabled: this.boolean(false)
        }
    }

    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/package'
            }
        }
    }

/*    static afterWhere (requests) {
        requests.forEach((request) => {
           //Fetch dependencies
            console.log(request);
        });

        return requests;
    }*/
}
