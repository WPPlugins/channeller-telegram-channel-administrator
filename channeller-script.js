        // Uploading files
        var file_frame;
    jQuery('#upload_image_button').live('click', function(podcast) {

        podcast.preventDefault();

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false // Set to true to allow multiple files to be selected
        });

        // When a file is selected, run a callback.
        file_frame.on('select', function(){
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();

            // here are some of the variables you could use for the attachment;
            //var all = JSON.stringify( attachment );      
            //var id = attachment.id;
            //var title = attachment.title;
            //var filename = attachment.filename;
            var url = attachment.url;
            //var link = attachment.link;
            //var alt = attachment.alt;
            //var author = attachment.author;
            //var description = attachment.description;
            //var caption = attachment.caption;
            //var name = attachment.name;
            //var status = attachment.status;
            //var uploadedTo = attachment.uploadedTo;
            //var date = attachment.date;
            //var modified = attachment.modified;
            //var type = attachment.type;
            //var subtype = attachment.subtype;
            //var icon = attachment.icon;
            //var dateFormatted = attachment.dateFormatted;
            //var editLink = attachment.editLink;
            //var fileLength = attachment.fileLength;

            var field = document.getElementById("tchannel_image");

            field.value = url; //set which variable you want the field to have
        });

        // Finally, open the modal
        file_frame.open();
    });
       // Uploading files
        var file_frame;
    jQuery('#upload_video_button').live('click', function(podcast) {

        podcast.preventDefault();

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false // Set to true to allow multiple files to be selected
        });

        // When a file is selected, run a callback.
        file_frame.on('select', function(){
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();

            // here are some of the variables you could use for the attachment;
            //var all = JSON.stringify( attachment );      
            //var id = attachment.id;
            //var title = attachment.title;
            //var filename = attachment.filename;
            var url = attachment.url;
            //var link = attachment.link;
            //var alt = attachment.alt;
            //var author = attachment.author;
            //var description = attachment.description;
            //var caption = attachment.caption;
            //var name = attachment.name;
            //var status = attachment.status;
            //var uploadedTo = attachment.uploadedTo;
            //var date = attachment.date;
            //var modified = attachment.modified;
            //var type = attachment.type;
            //var subtype = attachment.subtype;
            //var icon = attachment.icon;
            //var dateFormatted = attachment.dateFormatted;
            //var editLink = attachment.editLink;
            var fileLength = attachment.fileLength;

            var field = document.getElementById("tchannel_video");
            var fieldtime = document.getElementById("tchannel_video_time");

            field.value = url; //set which variable you want the field to have
            fieldtime.value = fileLength; //set which variable you want the field to have
        });

        // Finally, open the modal
        file_frame.open();
    });
       // Uploading files
        var file_frame;
    jQuery('#upload_audio_button').live('click', function(podcast) {

        podcast.preventDefault();

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false // Set to true to allow multiple files to be selected
        });

        // When a file is selected, run a callback.
        file_frame.on('select', function(){
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();

            // here are some of the variables you could use for the attachment;
            var all = JSON.stringify( attachment );      
            //var id = attachment.id;
            var title = attachment.title;
            //var filename = attachment.filename;
            var url = attachment.url;
            //var link = attachment.link;
            //var alt = attachment.alt;
            var author = attachment.meta.artist;
            //var description = attachment.description;
            //var caption = attachment.caption;
            //var name = attachment.name;
            //var status = attachment.status;
            //var uploadedTo = attachment.uploadedTo;
            //var date = attachment.date;
            //var modified = attachment.modified;
            //var type = attachment.type;
            //var subtype = attachment.subtype;
            //var icon = attachment.icon;
            //var dateFormatted = attachment.dateFormatted;
            //var editLink = attachment.editLink;
            var fileLength = attachment.fileLength;

            var field = document.getElementById("tchannel_audio");
            var fieldtime = document.getElementById("tchannel_audio_time");
            var fieldtitle = document.getElementById("tchannel_audio_title");
            var fieldauthor = document.getElementById("tchannel_audio_performer");

            field.value = url; //set which variable you want the field to have
            fieldtime.value = fileLength; //set which variable you want the field to have
            fieldtitle.value = title; //set which variable you want the field to have
            fieldauthor.value = author; //set which variable you want the field to have
        });

        // Finally, open the modal
        file_frame.open();
    });
