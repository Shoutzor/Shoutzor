import { Model } from '@vuex-orm/core';

import Album from "./Artist";
import AlbumMedia from "./AlbumMedia";
import Artist from "./Artist";
import ArtistMedia from "./ArtistMedia";

export default class Media extends Model {
    static entity = 'media'

    static fields () {
        return {
            id: this.uid(),
            title: this.string('Untitled'),
            filename: this.string(''),
            crc: this.string(''),
            duration: this.number(null),
            albums: this.belongsToMany(Album, AlbumMedia, 'media_id', 'album_id'),
            artists: this.belongsToMany(Artist, ArtistMedia, 'media_id', 'artist_id')
        }
    }
}
