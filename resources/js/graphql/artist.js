import gql from "graphql-tag";

export const ARTIST_QUERY = gql`
    query getArtist($id: ID!) {
        artist(id: $id) {
            id,
            image,
            name,
            summary
        }
    }`;

export const TOPARTISTS_QUERY = gql`
    query getTopArtists($album: ID!, $limit: Int) {
        topArtists(album: $album, limit: $limit) {
            id
            name
            image
        }
    }`;
