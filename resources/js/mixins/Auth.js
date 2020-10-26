import store from "@js/store/index";

const Auth = {
    methods: {
        $can(permissionName) {
            if (store.getters.isAuthenticated) {
                return store.getters.getUser.permissions.includes(permissionName);
            } else {
                //User is not authenticated, check permission against guest role
                return false;
            }
        },

        $isAuthenticated() {
            return store.getters.isAuthenticated;
        }
    }
}

export default Auth;
