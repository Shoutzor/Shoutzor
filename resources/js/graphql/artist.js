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
