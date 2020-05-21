import { Model } from '@vuex-orm/core';

import Media from './Media';
import AlbumArtist from './AlbumArtist';
import AlbumMedia from './AlbumMedia';

export default class Artist extends Model {
    static entity = 'artists';

    static fields () {
        return {
            id: this.number(null),
            title: this.string(''),
            summary: this.string(''),
            image: this.string(''),
            artists: this.belongsToMany(Artist, AlbumArtist, 'album_id', 'artist_id'),
            media: this.belongsToMany(Media, AlbumMedia, 'album_id', 'media_id')
        }
    }
}
