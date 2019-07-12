$(function(){
  var progressbar     = $("#progressbar"),
      bar             = progressbar.find('.progress-bar'),
      uploadList      = $("#uploadList"),
      uploadListEmpty = $("#uploadListEmpty"),
      isUploading     = false,
      itemsLeft       = 0,
      settings        = {
        action: '/api', // upload url
        single: true,
        param: 'musicfile',
        params: { method: "upload" },
        type: 'json',
        allow : '*.(wav|mp3|oga|flac|m4a|wma)', // allow only audio and video files

        beforeAll: function(files) {
            itemsLeft = files.length;
        },

        before: function(settings, file) {
            itemsLeft -= 1;
            if(itemsLeft < 0) {
                itemsLeft = 0;
            }
        },

        notallowed: function(file, settings) {
            //When an non-allowed file is beeing uploaded
            $("#not-allowed").removeClass('d-none');
        },

        loadstart: function() {
            isUploading = true;
            bar.css("width", "0%").text("0%");
            progressbar.removeClass("d-none");
        },

        progress: function(percent) {
            percent = Math.ceil(percent);

            if(percent == 100) {
                bar.css("width", "100%").text("100% Uploading complete - Please wait while the upload is processed.. | " + itemsLeft + " uploads remaining");
            } else {
                bar.css("width", percent+"%").text(percent+"% | " + itemsLeft + " uploads remaining");
            }
        },

        complete: function(response, xhr) {
            if(xhr.status != 200) {
                //Something happened
                $("#upload-error").removeClass("d-none");
                return;
            }

            if(response.info.code != 200) {
                //Something happened in our API
                $("#upload-error").removeClass("d-none");
                return;
            }

            //Hide the message telling us that the list is empty if we are adding one now
            if(uploadList.find("li:not(#uploadListEmpty)").length == 0) {
                uploadListEmpty.addClass("d-none");
            }

            uploadmanager.addItem(response.data);
        },

        allcomplete: function(response) {
            isUploading = false;

            bar.css("width", "100%").text("100%");

            setTimeout(function(){
                progressbar.addClass("d-none");
            }, 250);
        }
      };

  var select = UIkit.uploadSelect($("#upload-select"), settings),
      drop   = UIkit.uploadDrop($("#upload-drop"), settings);

  //Make sure users dont accidentally leave the page while uploads are still running
  window.onbeforeunload = function(e) {
      if(isUploading) {
          return 'You have still uploads running, if you leave this page these will be canceled. Are you sure you want to leave?';
      }
  };
});
