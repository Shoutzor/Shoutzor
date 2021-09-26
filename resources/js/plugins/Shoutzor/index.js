import Request from '@js/models/Request';
import Role from "@js/models/Role";
import MediaVote from '@js/models/MediaVote';

export default (app) => {
    return {
        install: function(app, options) {
            // Call the onReady method when the app reports it's ready
            app.emitter.on('app.ready', (data) => {
                this.onReady();
            });
        },

        /**
         * This method is called when the app.ready event is detected
         * effectively, the Shoutzor plugin is initialized here.
         */
        onReady: function() {
            //Fetch initial data
            var requestData = Request.api().fetch();
            var voteData = MediaVote.api().fetch();

            // Wait for the initial data to load
            Promise.all([requestData, voteData]).finally(() => {
                // Emit event to notify that the data has been updated once the promises are resolved
                app.emitter.emit("app.data.update");

                // Start Listening for events
                app.echo.listen('role.add', (payload) => Role.insert({data: payload}));
                app.echo.listen('role.change', (payload) => Role.insert({data: payload}));
                app.echo.listen('role.delete', (payload) => Role.delete(payload.id));
            });
        },
    };
};
