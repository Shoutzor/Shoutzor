import {Model} from '@vuex-orm/core';

import Media from './Media';
import Artist from './Artist';
import ArtistMedia from './ArtistMedia';

import {
    defaultAlbumImage,
    publicStoragePath
} from "../../js/config";

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

        return publicStoragePath + this.image;
    }

    get artists() {
        return this.media.artists;
    }

    static fields() {
        return {
            id: this.uid(null),
            title: this.string(''),
            summary: this.string(''),
            image: this.string(''),
            media: this.hasMany(Media, 'album_id')
        }
    }
}
