import gql from 'graphql-tag';

export const LIST_PERMISSIONS_QUERY = gql`
    query getAllPermissions {
        permissions {
            id
            name
            description
        }
    }`;
