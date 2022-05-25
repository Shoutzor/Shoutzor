import Request from '@js/models/Request';
import Role from '@js/models/Role';
import MediaVote from '@js/models/MediaVote';

/**
 * This class handles the main front-end application logic of Shoutzor.
 */
export class Shoutzor {
    constructor(app) {
        this.app = app;
        this.globals = app.config.globalProperties;
        this.store = this.globals.$store;
        this.emitter = this.globals.emitter;
        this.echo = this.globals.echo;
    }

    async initialize() {
        await this.loadAuth();
        await this.loadInitialData();
        await this.listenToSocket();

        // Let the app know it's ready to go
        this.emitter.emit('app.ready');
    }

    loadAuth() {
        //Resume an existing loginsession if the user has a valid token
        let resumeSession = (this.store.getters.hasToken) ? this.store.dispatch('resumeSession') : null;

        // Update the guest role
        let updateGuestRole = this.store.dispatch('updateGuestRole');

        return Promise.all([resumeSession, updateGuestRole]);
    }

    loadInitialData() {
        let requestData = Request.api().fetch();
        let voteData = MediaVote.api().fetch();

        return Promise.all([requestData, voteData]);
    }

    listenToSocket() {
        // Start Listening for events
        this.echo.listen('role', 'create', (payload) => Role.insert({data: payload}));
        this.echo.listen('role', 'update', (payload) => Role.update({data: payload}));
        this.echo.listen('role', 'delete', (payload) => Role.delete(payload.id));
    }
}