import {Model} from '@vuex-orm/core';

export default class ArtistMedia extends Model {
    static entity = 'artists_media'

    static primaryKey = ['artist_id', 'media_id'];

    static fields() {
        return {
            artist_id: this.uid(null),
            media_id: this.uid(null)
        }
    }
}
