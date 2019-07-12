var uploadmanager = {};

$(function() {
    uploadmanager = {

        itemTemplate: $.templates("#uploaded-item-template"),

        status: {
            0: {
                label: 'Waiting',
                labelclass: 'uk-badge-warning',
                progressbarclass: 'uk-progress-warning uk-progress-striped uk-active',
                progressbartext: 'Waiting to be processed..'
            },
            1: {
                label: 'Processing',
                labelclass: '',
                progressbarclass: 'uk-progress-striped uk-active',
                progressbartext: 'Processing..'
            },
            2: {
                label: 'Finished',
                labelclass: 'uk-badge-success',
                progressbarclass: 'uk-progress-success',
                progressbartext: 'Finished'
            },
            3: {
                label: 'Error',
                labelclass: 'uk-badge-danger',
                progressbarclass: 'uk-progress-danger',
                progressbartext: 'An error occurred while processing, please try again'
            },
            4: {
                label: 'Duplicate',
                labelclass: 'uk-badge-danger',
                progressbarclass: 'uk-progress-danger',
                progressbartext: 'This song has already been uploaded'
            },
            5: {
                label: 'Duration limit exceeded',
                labelclass: 'uk-badge-danger',
                progressbarclass: 'uk-progress-danger',
                progressbartext: 'This tracks length exceeds the configured duration limit allowed'
            },
            6: {
                label: 'Duration too short',
                labelclass: 'uk-badge-danger',
                progressbarclass: 'uk-progress-danger',
                progressbartext: 'This track is too short, a duration of at least 30 seconds is required'
            }
        },

        renderItem: function(media) {
            if(media.id === null) {
                media.id = 0;
            }

            options = $.extend({
                id: media.id,
                title: media.title
            }, uploadmanager.status[media.status]);

            return uploadmanager.itemTemplate.render(options);
        },

        addItem: function(media) {
            $("#uploadList").prepend(uploadmanager.renderItem(media));
        },

        updateItem: function(media) {
            $("#uploadList li[data-uploadid="+media.id+"]").andSelf().html(uploadmanager.renderItem(media));
        }

    };
});
