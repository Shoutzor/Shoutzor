import gql from "graphql-tag";

export const TOPMEDIA_QUERY = gql`
    query getTopMedia($album: ID, $artist: ID, $limit: Int) {
        topMedia(album: $album, artist: $artist, first: $limit) {
            paginatorInfo{
                total
                hasMorePages
            }
            data {
                id
                title
                is_video
                duration
                artists {
                    id,
                    name
                }
            }
        }
    }`;
