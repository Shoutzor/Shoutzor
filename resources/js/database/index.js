import VuexORM from '@vuex-orm/core'

import Album from '@/models/Album'
import AlbumArtist from '@/models/AlbumArtist'
import AlbumMedia from '@/models/AlbumMedia'
import Artist from '@/models/Artist'
import ArtistMedia from '@/models/ArtistMedia'
import Media from '@/models/Media'
import User from '@/models/User'
import Request from '@/models/Request'
import History from '@/models/History'

const database = new VuexORM.Database()

database.register(Album)
database.register(AlbumArtist)
database.register(AlbumMedia)
database.register(Artist)
database.register(ArtistMedia)
database.register(Media)
database.register(User)
database.register(Request)
database.register(History)

export default database
