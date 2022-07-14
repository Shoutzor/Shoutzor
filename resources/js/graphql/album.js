import gql from "graphql-tag";

export const TOPALBUMS_QUERY = gql`
    query getTopAlbums($artist: ID!, $limit: Int) {
        topAlbums(artist: $artist, limit: $limit) {
            id
            title
            image
        }
    }`;
