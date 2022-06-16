import gql from "graphql-tag";

export const LOGIN_MUTATION = gql`
    mutation login($input: LoginInput!) {
        login(input: $input) {
            token
        }
    }`;

export const LOGOUT_MUTATION = gql`
    mutation logout {
        logout {
            status
            message
        }
    }`;

export const WHOAMI_MUTATION = gql`
    mutation whoami {
        whoami {
            user {
                id
                username
                email
                is_admin
            }
        }
    }`;
