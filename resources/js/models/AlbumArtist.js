import {Model} from '@vuex-orm/core';

export default class AlbumArtist extends Model {
    static entity = 'albums_artists'

    static primaryKey = ['album_id', 'artist_id'];

    static fields() {
        return {
            album_id: this.uid(null),
            artist_id: this.uid(null)
        }
    }
}
