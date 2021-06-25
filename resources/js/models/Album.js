import {Model} from '@vuex-orm/core';

import Media from './Media';
import Artist from './Artist';
import AlbumArtist from './AlbumArtist';
import AlbumMedia from './AlbumMedia';

import {defaultAlbumImage} from "../config";

export default class Album extends Model {
    static entity = 'albums';

    static apiConfig = {
        actions: {
            fetchById(id) {
                return this.get('/api/album/get/${id}');
            }
        }
    }

    get albumImage() {
        if (this.image === '') {
            return defaultAlbumImage;
        }

        return this.image;
    }

    static fields() {
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
