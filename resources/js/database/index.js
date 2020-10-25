import VuexORM from '@vuex-orm/core'

import Album from '@js/models/Album'
import AlbumArtist from '@js/models/AlbumArtist'
import AlbumMedia from '@js/models/AlbumMedia'
import Artist from '@js/models/Artist'
import ArtistMedia from '@js/models/ArtistMedia'
import Media from '@js/models/Media'
import Package from '@js/models/Package'
import Request from '@js/models/Request'
import History from '@js/models/History'
import Task from '@js/models/Task'
import Permission from '@js/models/Permission'
import Role from '@js/models/Role'
import User from '@js/models/User'
import RolePermission from "@js/models/RolePermission";
import UserPermission from "@js/models/UserPermission";
import UserRole from "@js/models/UserRole";

const database = new VuexORM.Database()

database.register(Album)
database.register(AlbumArtist)
database.register(AlbumMedia)
database.register(Artist)
database.register(ArtistMedia)
database.register(Media)
database.register(Package)
database.register(History)
database.register(Task)
database.register(Permission)
database.register(Role)
database.register(User)
database.register(RolePermission);
database.register(UserPermission);
database.register(UserRole);
database.register(Request)

export default database
