import Vue from 'vue';
import Request from '@js/models/Request';

var Shoutzor = {
    install: function(Vue, options) {
        let self = this;

        // Call the onReady method when the app reports it's ready
        Vue.bus.on('app.ready', function(data) {
            self.onReady(self);
        });
    },

    /**
     * This method is called when the app.ready event is detected
     * effectively, the Shoutzor plugin is initialized here.
     * @param self
     */
    onReady: function(self) {
        // Fetch initial data
        self.updateData();

        // Update data upon authentication state change
        Vue.bus.on('auth.state', function(data){
            self.updateData();
        });
    },

    /**
     * When this method is called, new data is fetched from the API
     */
    updateData: function() {
        let requestData = Request.api().fetch();

        // Emit event to notify that the data has been updated once the promises are resolved
        Promise.all([requestData]).finally(() => {
            Vue.bus.emit("app.data.update");
        })
    }
};

export default Shoutzor;
