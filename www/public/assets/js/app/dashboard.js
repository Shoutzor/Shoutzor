$(function() {

    var dashboard = {

        rowTemplate: $.templates("#dashboard-table-row-template"),

        getLocalTime: function(date) {
            var now = date,
                tzo = -now.getTimezoneOffset(),
                dif = tzo >= 0 ? '+' : '-',
                pad = function(num) {
                    var norm = Math.abs(Math.floor(num));
                    return (norm < 10 ? '0' : '') + norm;
                };
            return now.getFullYear()
                + '-' + pad(now.getMonth()+1)
                + '-' + pad(now.getDate())
                + 'T' + pad(now.getHours())
                + ':' + pad(now.getMinutes())
                + ':' + pad(now.getSeconds())
                + dif + pad(tzo / 60)
                + ':' + pad(tzo % 60);
        },

        buildArtistList: function(artists) {
            var list = '';

            if(artists.length === 0) {
                return 'Unknown';
            }

            $.each(artists, function(key, artist) {
                if(list !== '') {
                    list += ', ';
                }

                list += '<a href="' + artist.url + '">' + artist.name + '</a>';
            });

            return list;
        },

        buildAlbumList: function(albums) {
            var list = '';

            if(albums.length === 0) {
                return 'Unknown';
            }

            $.each(albums, function(key, album) {
                if(list !== '') {
                    list += ', ';
                }

                list += '<a href="' + album.url + '">' + album.title + '</a>';
            });

            return list;
        },

        buildQueueTableRows: function(tracks, starttime) {
            var result = '';

            starttime = starttime * 1000; //Convert to milliseconds

            $.each(tracks, function(key, track) {
                result += dashboard.rowTemplate.render({
                    title: track.title,
                    artist: dashboard.buildArtistList(track.artist),
                    album: dashboard.buildAlbumList(track.album),
                    duration: $.format.date(dashboard.getLocalTime(new Date(starttime)), 'yyyy-MM-dd HH:mm:ss')
                });

                starttime += track.duration * 1000; //Add the time in milliseconds from this track to the starttime
            });

            return result;
        },

        buildHistoryTableRows: function(tracks) {
            var result = '';

            $.each(tracks, function(key, track) {
                result += dashboard.rowTemplate.render({
                    title: track.title,
                    artist: dashboard.buildArtistList(track.artist),
                    album: dashboard.buildAlbumList(track.album),
                    duration: $.format.date(dashboard.getLocalTime(new Date(track.played_at + ' UTC')), 'yyyy-MM-dd HH:mm:ss')
                });
            });

            return result;
        },

        updateQueueList: function() {
            api.queuelist(function(result) {
                if(result.result === false) {
                    //Error handling
                } else {
                    //Clear the current list
                    $("#queue-table tbody").html(dashboard.buildQueueTableRows(result.tracks, starttime));
                }
            });
        },

        updateHistoryList: function() {
            api.historylist(function(result) {
                if(result.result === false) {
                    //Error handling
                } else {
                    //Clear the current list
                    $("#history-table tbody").html(dashboard.buildHistoryTableRows(result.tracks));
                }
            });
        },

        autoUpdate: function() {
            dashboard.updateQueueList();
            dashboard.updateHistoryList();

            setTimeout(function() {
                dashboard.autoUpdate();
            }, 10000);
        }
    };

    dashboard.autoUpdate();
});
