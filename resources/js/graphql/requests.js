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
                    duration
                    artists {
                        id
                        name
                    }
                }
            }
        }
    }`;

export const COMINGUP_QUERY = gql`
    query getRequests {
        requests(where: { column: PLAYED_AT, operator: IS_NULL }) {
            paginatorInfo{
                total
                hasMorePages
            }
            data {
                id
                media {
                    id
                    title
                    is_video
                    duration
                    artists {
                        id,
                        name
                    }
                }
                requested_at
                requested_by {
                    id
                    username
                }
            }
        }
    }`;

export const HISTORY_QUERY = gql`
    query getHistory {
        requests(
            where: { column: PLAYED_AT, operator: IS_NOT_NULL }
            orderBy: { column: "played_at", order: DESC }
        ) {
            paginatorInfo{
                total
                hasMorePages
            }
            data {
                id
                media {
                    id
                    title
                    is_video
                    duration
                    album {
                        id
                        title
                    }
                    artists {
                        id,
                        name
                    }
                }
                played_at
                requested_by {
                    id
                    username
                }
            }
        }
    }`;

export const ADDREQUEST_MUTATION = gql`
    mutation addRequest($id: ID!) {
        addRequest(id: $id) {
            success
            message
        }
    }`;

export const REQUESTADDED_SUBSCRIPTION = gql`
    subscription onRequestAdded {
        requestAdded {
            id
            media {
                id
                title
                is_video
                duration
                album {
                    id
                    title
                }
                artists {
                    id,
                    name
                }
            }
            requested_by {
                id
                username
            }
            requested_at
            played_at
        }
    }`;
