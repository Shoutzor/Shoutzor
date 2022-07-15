import gql from "graphql-tag";

export const ALBUM_QUERY = gql`
    query getAlbum($id: ID!) {
        album(id: $id) {
            id,
            image,
            title,
            summary
        }
    }`;


export const TOPALBUMS_QUERY = gql`
    query getTopAlbums($artist: ID!, $limit: Int) {
        topAlbums(artist: $artist, limit: $limit) {
            id
            title
            image
        }
    }`;
