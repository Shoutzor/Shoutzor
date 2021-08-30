import Vue from 'vue';
import Request from '@js/models/Request';
import MediaVote from '@js/models/MediaVote';

var updateDataHandle = null;
var Shoutzor = {
    install: function (Vue, options) {
        // Call the onReady method when the app reports it's ready
        Vue.bus.on('app.ready', (data) => {
            this.onReady();
        });
    },

    /**
     * This method is called when the app.ready event is detected
     * effectively, the Shoutzor plugin is initialized here.
     * @param self
     */
    onReady: function () {
        // Fetch initial data
        this.updateData();

        // Update data upon authentication state change
        Vue.bus.on('auth.state', (data) => {
            this.updateData();
        });
    },

    /**
     * When this method is called, new data is fetched from the API
     * @emits app.data.update this event is emitted when Shoutzor has finished loading new data from the API
     */
    updateData: function () {
        //When the updateData method is called, reset the timeout.
        window.clearTimeout(updateDataHandle);

        //Fetch the (new) data
        var requestData = Request.api().fetch();
        var voteData = MediaVote.api().fetch();

        // Emit event to notify that the data has been updated once the promises are resolved
        Promise.all([requestData, voteData]).finally(() => {
            Vue.bus.emit("app.data.update");

            //Set the new timeout to update the data again
            updateDataHandle = window.setTimeout(() => {
                this.updateData();
            }, 5000);
        });
    }
};

export default Shoutzor;
