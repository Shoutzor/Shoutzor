import {Model} from '@vuex-orm/core';

export default class ArtistArtist extends Model {
    static entity = 'albums_artists'

    static primaryKey = ['album_id', 'artist_id'];

    static fields() {
        return {
            album_id: this.number(null), artist_id: this.number(null)
        }
    }
}
