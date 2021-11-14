import VuexORM from '@vuex-orm/core'

import Album from '@js/models/Album'
import Artist from '@js/models/Artist'
import ArtistMedia from '@js/models/ArtistMedia'
import Media from '@js/models/Media'
import Request from '@js/models/Request'
import RequestUser from '@js/models/RequestUser'
import Task from '@js/models/Task'
import Permission from '@js/models/Permission'
import Role from '@js/models/Role'
import User from '@js/models/User'
import RolePermission from "@js/models/RolePermission";
import UserPermission from "@js/models/UserPermission";
import UserRole from "@js/models/UserRole";
import MediaVote from "@js/models/MediaVote";

const database = new VuexORM.Database();

database.register(Album);
database.register(Artist);
database.register(ArtistMedia);
database.register(Media);
database.register(Task);
database.register(Permission);
database.register(Request);
database.register(RequestUser);
database.register(Role);
database.register(User);
database.register(RolePermission);
database.register(UserPermission);
database.register(UserRole);
database.register(MediaVote);

export default database
