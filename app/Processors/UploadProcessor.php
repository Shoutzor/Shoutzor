<?php

namespace App\Processors;

use App\Events\Internal\UploadFailedEvent;
use App\Events\Internal\UploadFinishedEvent;
use App\Events\Internal\UploadProcessingEvent;
use App\Exceptions\UploadFailedFinalException;
use App\Exceptions\UploadFailedRetryException;
use App\Media;
use App\Upload;
use Exception;
use getID3;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\EventDispatcher\EventDispatcher;

class UploadProcessor
{

    private $id3;
    private $mediaDir;
    private $tempMediaDir;

    public function __construct()
    {
        $this->id3 = new getID3();
        $this->mediaDir = Media::STORAGE_PATH;
        $this->tempMediaDir = Upload::STORAGE_PATH;
    }

    public function parse(Upload $upload)
    {
        //Send the event that an upload is being processed
        $event = new UploadProcessingEvent($upload);
        app(EventDispatcher::class)->dispatch($event);

        try {
            //Create the media object from the upload
            $media = $this->process($upload);

            $this->checkIfUnique($media);

            // Move the media file from the temp upload directory to its persistent directory
            Storage::move(
                $this->tempMediaDir.$upload->filename,
                $this->mediaDir.$media->filename
            );

            // Save the media instance to the database
            $media->save();

            //Trigger the event that the upload processing has finished
            app(EventDispatcher::class)->dispatch(new UploadFinishedEvent($upload, $media));

            // Delete the upload from the database
            $upload->delete();
        } // A (temporary) error occured while processing, will retry later.
        catch (UploadFailedRetryException $e) {
            $upload->status = Upload::STATUS_FAILED_RETRY;
            $upload->save();

            # TODO add some kind of timeout / cooldown period before trying again?

            //Trigger the event that the upload processing has failed
            app(EventDispatcher::class)->dispatch(new UploadFailedEvent($upload));
        } //Something happened while processing the upload
        catch (Exception $e) {
            $upload->status = Upload::STATUS_FAILED_FINAL;
            $upload->save();

            # TODO process the failed uploads for cleanup

            //Trigger the event that the upload processing has failed
            app(EventDispatcher::class)->dispatch(new UploadFailedEvent($upload));
        }
    }

    private function process(Upload $upload): Media
    {
        $media = new Media(
            [
                'title' => '',
                'filename' => Storage::get($this->tempMediaDir.$upload->filename),
                'crc' => 'invalid',
                'duration' => 0,
                'is_video' => false
            ]
        );

        # Calculate the CRC hash of the file
        $media->crc = hash_file('crc32', $media->filename);

        # Get the duration of the file
        $media->duration = $this->getDuration($media);

        return $media;
    }

    /**
     * Calculates the duration (in seconds) of a file
     */
    private function getDuration(Media $media)
    {
        $info = $this->id3->analyze($this->tempMediaDir.'/'.$media->filename);
        $time = $info['playtime_string'];
        $time = explode(':', $time);

        $hours = (count($time) == 3) ? $time[0] : 0;
        $mins = (count($time) > 1) ? $time[count($time) - 2] : 0;
        $secs = $time[count($time) - 1];

        $seconds = mktime($hours, $mins, $secs) - mktime(0, 0, 0);

        return $seconds;
    }

    /**
     * @throws Exception if the Media file is not unique
     */
    private function checkIfUnique(Media $media)
    {
        $exist = Media::query()->where('crc', $media->crc)->first();

        if ($exist) {
            throw new UploadFailedFinalException("A file with the same CRC-hash is already in the database");
        }
    }

}
