import {Model} from '@vuex-orm/core';

import Album from "./Album";
import AlbumMedia from "./AlbumMedia";
import Artist from "./Artist";
import ArtistMedia from "./ArtistMedia";
import MediaSource from "./MediaSource";

import {defaultAlbumImage} from "../config";

export default class Media extends Model {
    static entity = 'media'

    get coverImage() {
        console.log("hi");
        console.log(this.image);
        if(this.image.length > 0) {
            return this.image;
        }

        if (this.albums !== null && this.albums.length > 0) {
            return this.albums[0].albumImage;
        }

        return defaultAlbumImage;
    }

    static fields() {
        return {
            id: this.number(null),
            title: this.string('Untitled'),
            filename: this.string(''),
            duration: this.number(0),
            is_video: this.boolean(false),
            image: this.string(''),
            source: this.belongsTo(MediaSource, 'media_id'),
            albums: this.belongsToMany(Album, AlbumMedia, 'media_id', 'album_id'),
            artists: this.belongsToMany(Artist, ArtistMedia, 'media_id', 'artist_id')
        }
    }
}