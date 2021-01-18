import { Model } from '@vuex-orm/core';

import Media from './Media';
import ArtistMedia from './ArtistMedia';

export default class Artist extends Model {
    static entity = 'artists';

    static fields () {
        return {
            id: this.uid(),
            name: this.string(''),
            summary: this.string(''),
            image: this.string(''),
            media: this.belongsToMany(Media, ArtistMedia, 'artist_id', 'media_id')
        }
    }
}
