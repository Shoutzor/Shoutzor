import gql from 'graphql-tag';

export const LASTPLAYED_REQUEST_QUERY = gql`
    query LastPlayedRequestQuery {
        requests(
            first: 1
            orderBy: { column: "played_at", order: DESC }
        ) {
            data {
                id
                media {
                    id
                    title
                    image
                    artists {
                        id,
                        name
                    }
                }
                requested_by {
                    id
                    username
                }
            }
        }
    }`;

export const LASTPLAYED_UPDATED_SUBSCRIPTION = gql`
    subscription onLastPlayedUpdate {
        lastPlayedRequestUpdated {
            id
            played_at
        }
    }`;
