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

    onReady: function(self) {
        // Fetch initial data
        self.updateData();

        // Update data upon authentication state change
        Vue.bus.on('auth.state', function(data){
            self.updateData();
        });
    },

    updateData: function() {
        Request.api().fetch();
    }
};

export default Shoutzor;
