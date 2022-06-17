import gql from 'graphql-tag';

export const LASTPLAYED_MUTATION = gql`
    mutation lastPlayed {
        lastPlayed {
            request {
                id
                requested_by {
                    id
                    username
                }
                media {
                    id
                    title
                    image
                    artists {
                        id
                        name
                    }
                }
            }
        }
    }`;
