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
        $media = new Media([
            'title' => '',
            'filename' => Storage::get(Upload::STORAGE_PATH . $upload->filename),
            'crc' => 'invalid',
            'duration' => 0,
            'is_video' => false
        ]);

        //Send the event that an upload has been added
        $event = new UploadProcessingEvent($upload, $media);
        app(EventDispatcher::class)->dispatch($event);

        /*
         * TODO add media validation as an eventhandler
         */

        //Check if any listeners/subscribers marked the upload as invalid
        if($event->isValid()) {
            // Move the media file from the temp upload directory to its persistent directory
            Storage::move(Upload::STORAGE_PATH . $upload->filename, Media::STORAGE_PATH . $media->filename);

            // Save the media instance to the database
            $media->save();

            //Trigger the event that the upload processing has finished
            app(EventDispatcher::class)->dispatch(new UploadFinishedEvent($upload, $media));

            // Delete the upload from the database
            $upload->delete();
        }
        //The upload was marked as invalid
        else {
            $upload->status = Upload::STATUS_FAILED;
            $upload->save();

            //Trigger the event that the upload processing has failed
            app(EventDispatcher::class)->dispatch(new UploadFailedEvent($upload));
        }
    }

}
