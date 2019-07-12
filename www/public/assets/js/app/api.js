var api = {
    url: "/shoutzorapi",

    executeRequest: function(request) {
        request = $.extend({
            url: api.url,
            type: "GET",
            data: {}
        }, request);

        return $.ajax({
            url: request.url,
            type: request.type,
            data: request.data
        });
    },

    //Starts the liquidsoap script of the provided type
    startscript: function(type, callback) {
        api.executeRequest({
            data: {
                method: "liquidsoapcommand",
                command: "start",
                type: type
            }
        }).always(function(data, type) {
            var result = false;
            var message = '';

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                    message = 'The script is starting';
                } else {
                    message = data.data;
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
                message = 'Sorry! Something went wrong!';
            }

            callback({
                result: result,
                message: message
            });
        });
    },

    //Starts the liquidsoap script of the provided type
    stopscript: function(type, callback) {
        api.executeRequest({
            data: {
                method: "liquidsoapcommand",
                command: "stop",
                type: type
            }
        }).always(function(data, type) {
            var result = false;
            var message = '';

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                    message = 'The script is stopping';
                } else {
                    message = data.data;
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
                message = 'Sorry! Something went wrong!';
            }

            callback({
                result: result,
                message: message
            });
        });
    },

    nexttrack: function(callback) {
        api.executeRequest({
            data: {
                method: "liquidsoapcommand",
                command: "next"
            }
        }).always(function(data, type) {
            var result = false;
            var message = '';

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                    message = 'Skipped to the next track';
                } else {
                    message = data.data;
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
                message = 'Sorry! Something went wrong!';
            }

            callback({
                result: result,
                message: message
            });
        });
    },

    //Request a media file to be played
    request: function(trackid, callback) {
        api.executeRequest({
            data: {
                method: "request",
                id: trackid
            }
        }).always(function(data, type) {
            var result = false;
            var message = '';

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                    message = 'Your request has been added';
                } else {
                    message = data.data;
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
                message = 'Sorry! Something went wrong!';
            }

            callback({
                result: result,
                message: message
            });
        });
    },

    //Get the queued request list
    queuelist: function(callback) {
        api.executeRequest({
            data: {
                method: "queuelist"
            }
        }).always(function(data, type) {
            var result = false;
            var tracks = {};
            starttime = 0;

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                    tracks = data.data.tracks;
                    starttime = data.data.starttime;
                } else {
                    //Something went wrong
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
            }

            callback({
                result: result,
                tracks: tracks,
                starttime: starttime
            });
        });
    },

    //Get the request history list
    historylist: function(callback) {
        api.executeRequest({
            data: {
                method: "historylist"
            }
        }).always(function(data, type) {
            var result = false;
            var tracks = {};

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                    tracks = data.data.tracks;
                } else {
                    //Something went wrong
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
            }

            callback({
                result: result,
                tracks: tracks
            });
        });
    },

    //Get the track that is playing right now
    nowplaying: function(callback) {
        api.executeRequest({
            data: {
                method: "nowplaying"
            }
        }).always(function(data, type) {
            var result = false;
            var track = {};

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                    track = data.data;
                } else {
                    //Something went wrong
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
            }

            callback({
                result: result,
                track: track
            });
        });
    },

    //Execute a liquidsoapcommand
    liquidsoapcommand: function(params, callback) {
        data = $.extend({
            method: "liquidsoapcommand"
        }, params);

        api.executeRequest({
            data: data
        }).always(function(data, type) {
            var result = false;
            var response = data;

            //make sure the request did not fail
            if (type == "success") {
                //API call went through, make sure the call succeeded
                if(data.info.code == 200) {
                    result = true;
                } else {
                    //Something went wrong
                }
            } else {
                //Some error happened when trying to make the API call (500 perhaps?)
            }

            callback({
                result: result,
                response: response
            });
        });
    }
};
