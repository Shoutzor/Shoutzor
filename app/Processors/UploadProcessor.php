<?php

namespace App\Processors;

use App\Events\Internal\UploadFailedEvent;
use App\Events\Internal\UploadFinishedEvent;
use App\Events\Internal\UploadProcessingEvent;
use App\Media;
use App\Upload;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\EventDispatcher\EventDispatcher;

class UploadProcessor {

    public function parse(Upload $upload) {
        //Create the initial media object to be passed along
        $media = new Media(['title' => '', 'filename' => Storage::get(Upload::STORAGE_PATH.$upload->filename), 'crc' => 'invalid', 'duration' => 0, 'is_video' => false]);

        //Send the event that an upload has been added
        $event = new UploadProcessingEvent($upload, $media);
        app(EventDispatcher::class)->dispatch($event);

        var_dump(app(EventDispatcher::class));

        die("passed event processing");

        // Check if the resulting media object is valid
        if($media->isValid() === false) {
            // Resulting media object is invalid, marking the upload event as invalid
            $event->setInvalid();

            // Setting the upload status to failed
            $upload->status = Upload::STATUS_FAILED;

            //TODO perhaps throw an exception?
        }

        //Save any changes to the upload object, possible changes could be: reason (upload failed, already exists, etc)
        $upload->save();

        //Check if any listeners/subscribers marked the upload as invalid
        if($event->isValid()) {
            // Move the media file from the temp upload directory to its persistent directory
            Storage::move(Upload::STORAGE_PATH.$upload->filename, Media::STORAGE_PATH.$media->filename);

            // Save the media instance to the database
            $media->save();

            //Trigger the event that the upload processing has finished
            app(EventDispatcher::class)->dispatch(new UploadFinishedEvent($upload, $media));

            // Delete the upload from the database
            $upload->delete();
        }
        //The upload was marked as invalid
        else {
            //Trigger the event that the upload processing has failed
            app(EventDispatcher::class)->dispatch(new UploadFailedEvent($upload));
        }
    }

}
