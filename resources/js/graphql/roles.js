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
