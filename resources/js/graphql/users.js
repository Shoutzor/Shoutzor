import gql from 'graphql-tag';

export const LIST_USERS_QUERY = gql`
    query getUsers($page: Int, $limit: Int) {
        users(page: $page, first: $limit) {
            paginatorInfo{
                currentPage
                lastPage
                total
            }
            data {
                id
                username
                created_at
                email_verified_at
                roles {
                    id
                    name
                }
                is_admin
            }
        }
    }`;
