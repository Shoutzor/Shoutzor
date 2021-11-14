import {Model} from '@vuex-orm/core';

import Album from "./Album";
import Artist from "./Artist";
import ArtistMedia from "./ArtistMedia";
import MediaSource from "./MediaSource";

import {
    publicStoragePath,
    defaultAlbumImage
} from "../config";

export default class Media extends Model {
    static entity = 'media'

    static apiConfig = {
        actions: {
            fetch: {
                method: 'get',
                url: '/api/media/get'
            }
        }
    }

    get coverImage() {
        if(this.image.length > 0) {
            return publicStoragePath + this.image;
        }

        if (this.album !== null) {
            return this.album.albumImage;
        }

        return defaultAlbumImage;
    }

    static fields() {
        return {
            id: this.uid(null),
            title: this.string('Untitled'),
            filename: this.string(''),
            duration: this.number(0),
            is_video: this.boolean(false),
            image: this.string(''),
            album_id: this.uid(null),
            source: this.belongsTo(MediaSource, 'media_id'),
            album: this.belongsTo(Album, 'album_id'),
            artists: this.belongsToMany(Artist, ArtistMedia, 'media_id', 'artist_id')
        }
    }
}