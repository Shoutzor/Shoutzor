import Vue from "vue";
import {Model} from '@vuex-orm/core';

import Album from "./Album";
import AlbumMedia from "./AlbumMedia";
import Artist from "./Artist";
import ArtistMedia from "./ArtistMedia";

import {defaultAlbumImage} from "../config";

export default class Media extends Model {
    static entity = 'media'

    get coverImage() {
        if (this.albums === null || this.albums.length === 0) {
            return defaultAlbumImage;
        }

        return this.albums[0].albumImage;
    }

    static fields() {
        return {
            id: this.number(null),
            title: this.string('Untitled'),
            filename: this.string(''),
            crc: this.string(''),
            duration: this.number(0),
            is_video: this.boolean(false),
            source: this.attr([]),
            albums: this.belongsToMany(Album, AlbumMedia, 'media_id', 'album_id'),
            artists: this.belongsToMany(Artist, ArtistMedia, 'media_id', 'artist_id')
        }
    }
}
