import VuexORM from '@vuex-orm/core'

import Album from '@js/models/Album'
import AlbumArtist from '@js/models/AlbumArtist'
import AlbumMedia from '@js/models/AlbumMedia'
import Artist from '@js/models/Artist'
import ArtistMedia from '@js/models/ArtistMedia'
import Media from '@js/models/Media'
import Package from '@js/models/Package'
import User from '@js/models/User'
import Request from '@js/models/Request'
import History from '@js/models/History'
import Task from '@js/models/Task'

const database = new VuexORM.Database()

database.register(Album)
database.register(AlbumArtist)
database.register(AlbumMedia)
database.register(Artist)
database.register(ArtistMedia)
database.register(Media)
database.register(Package)
database.register(User)
database.register(Request)
database.register(History)
database.register(Task)

export default database
