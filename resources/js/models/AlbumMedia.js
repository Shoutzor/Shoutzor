import {Model} from '@vuex-orm/core';

export default class AlbumMedia extends Model {
    static entity = 'albums_media'

    static primaryKey = ['album_id', 'media_id'];

    static fields() {
        return {
            album_id: this.uid(null),
            media_id: this.uid(null)
        }
    }
}
