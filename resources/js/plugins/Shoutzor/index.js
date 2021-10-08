import Request from '@js/models/Request';
import Role from '@js/models/Role';
import MediaVote from '@js/models/MediaVote';

export default {
    install: (app, options) => {
        let globals = app.config.globalProperties;
        let store = globals.$store;
        let emitter = globals.emitter;
        let echo = globals.echo;

        //Resume an existing loginsession if the user has a valid token
        const resumeSession = (store.getters.hasToken) ? store.dispatch('resumeSession') : null;

        // Update the guest role
        const updateGuestRole = store.dispatch('updateGuestRole');

        //Fetch initial data
        var requestData = Request.api().fetch();
        var voteData = MediaVote.api().fetch();

        //Wait for both updates to finish loading
        Promise.all([resumeSession, updateGuestRole, requestData, voteData]).finally(() => {
            emitter.emit('app.ready');

            this.listenToSocket(echo);
        })
    },

    listenToSocket(echo) {
        // Start Listening for events
        echo.listen('role', 'create', (payload) => Role.insert({data: payload}));
        echo.listen('role', 'update', (payload) => Role.update({data: payload}));
        echo.listen('role', 'delete', (payload) => Role.delete(payload.id));
    }
}