import gql from 'graphql-tag';

export const LIST_ROLES_QUERY = gql`
    query getRoles($page: Int, $limit: Int) {
        roles(page: $page, first: $limit) {
            paginatorInfo{
                lastPage
                total
            }
            data {
                id
                name
                description
                protected
            }
        }
    }`;

export const GET_ROLE_QUERY = gql`
    query getRole($id: ID) {
        role(id: $id) {
            id
            name
            description
            protected
            permissions {
                id
                name
                description
            }
        }
    }`;
