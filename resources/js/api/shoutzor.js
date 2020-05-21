/**
 * Mocking client-server processing
 */
const _artists = [
    {"id": 1, "name": "Deadmau5", "summary": "test description", "image": "artist.jpg"},
    {"id": 2, "name": "Ava max", "summary": "test description", "image": "artist.jpg"},
    {"id": 3, "name": "Rick Astley", "summary": "test description", "image": "artist.jpg"},
    {"id": 4, "name": "Eddie Murphy", "summary": "test description", "image": "artist.jpg"},
    {"id": 5, "name": "AntonioBanderas", "summary": "test description", "image": "artist.jpg"}
];

const _albums = [
    {"id": 1, "title": "test album", "summary": "test description", "image": "album.jpg"},
    {"id": 2, "title": "another test album", "summary": "test description", "image": "album.jpg"}
];

const _media = [
    {"id": 1, "title": "Never gonna give you up", "filename": "test1.mp3", "crc": "temp_invalid", "duration": 120},
    {"id": 2, "title": "Sweet but Psycho", "filename": "test2.mp3", "crc": "temp_invalid", "duration": 233},
    {"id": 3, "title": "Ghosts 'n stuff", "filename": "test3.mp3", "crc": "temp_invalid", "duration": 216}
];

const _requests = [
    {"id": 1, "media_id": 1, "user_id": null, "requested_at": "2020-04-21 03:14:07"}
];

const _history = [
    {"id": 1, "media_id": 1, "user_id": null, "played_at": "2020-04-21 03:14:07"},
    {"id": 2, "media_id": 3, "user_id": null, "played_at": "2020-04-21 03:16:07"},
    {"id": 3, "media_id": 2, "user_id": null, "played_at": "2020-04-21 03:19:07"}
];

export default {
    fetchArtists (cb) {
        setTimeout(() => cb(_artists), 100)
    },

    fetchAlbums (cb) {
        setTimeout(() => cb(_albums), 100)
    },

    fetchMedia (cb) {
        setTimeout(() => cb(_media), 100)
    },

    fetchRequests (cb) {
        setTimeout(() => cb(_requests), 100)
    },

    fetchHistory (cb) {
        setTimeout(() => cb(_history), 100)
    }
}
