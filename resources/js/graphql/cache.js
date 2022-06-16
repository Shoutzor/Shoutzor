import { InMemoryCache } from '@apollo/client';
import {ref} from "vue";

export const cache = new InMemoryCache({
    typePolicies: {
        Query: {
            fields: {
                isLoggedIn: {
                    read() {
                        return isLoggedInVar;
                    }
                },
                launches: {
                    // ...field policy definitions...
                },
            },
        },
    },
});

// Initializes to true if localStorage includes a 'token' key, false otherwise
export const isLoggedInVar = ref(!!localStorage.getItem('token'));
