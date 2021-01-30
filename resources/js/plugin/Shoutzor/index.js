import Request from '@js/models/Request';
import History from '@js/models/History';

var Shoutzor = {
    install: function(Vue, options) {
        let self = this;
        this.updateData();

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
