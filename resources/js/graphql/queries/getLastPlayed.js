import gql from "graphql-tag";

export const LASTPLAYED_QUERY = gql`
    query getLastPlayed {
        requests(
            first: 1
            orderBy: { column: "played_at", order: DESC }
        ) {
            paginatorInfo{
                total
                hasMorePages
            }
            data {
                id
                media {
                    title
                    image
                    artists {
                        id,
                        name
                    }
                }
                requested_by {
                    username
                }
            }
        }
    }`;

