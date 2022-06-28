import gql from 'graphql-tag';

export const SEARCH_QUERY = gql`
    query searchQuery($q: String!) {
        search(q: $q) {
            media {
                id
                title
                image
                is_video
                artists {
                    id
                    name
                }
                album {
                    title
                }
            }
            artists {
                id
                name
                image
            }
            albums {
                id
                title
                image
            }
        }
    }`;
