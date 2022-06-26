<?php

namespace App\Processors;

use App\Exceptions\UploadExistsException;
use App\Models\Media;
use App\Models\Upload;
use Exception;
use getID3;
use Illuminate\Support\Facades\Storage;

class UploadProcessor
{

    private getID3 $id3;
    private string $mediaDir;
    private string $tempMediaDir;

    public function __construct()
    {
        $this->id3 = new getID3();
        $this->mediaDir = Media::STORAGE_PATH;
        $this->tempMediaDir = Upload::STORAGE_PATH;
    }

    /**
     * @throws UploadExistsException
     */
    public function parse(Upload $upload)
    {
        //Create the base media object
        $media = $this->createBaseMediaObject($upload);

        // Check if the base media object is unique
        $this->checkIfUnique($media);

        // Move the media file from the temp upload directory to its persistent directory
        Storage::move(
            $this->tempMediaDir . $upload->filename,
            $this->mediaDir . $media->filename
        );

        // Save the media instance to the database
        $media->save();

        // Delete the upload from the database
        $upload->delete();
    }

    /**
     * Create the base media object for the uploaded file
     * This method only sets some default properties and does not do any saniziting or processing yet.
     * @param Upload $upload
     * @return Media
     */
    private function createBaseMediaObject(Upload $upload): Media
    {
        $media = new Media(
            [
                'title' => '',
                'filename' => Storage::get($this->tempMediaDir . $upload->filename),
                'crc' => 'invalid',
                'duration' => 0,
                'is_video' => false
            ]
        );

        # Calculate the CRC hash of the file
        $media->hash = hash_file('sha512', $media->filename);

        # Get the duration of the file
        $media->duration = $this->getDuration($media);

        return $media;
    }

    /**
     * Calculates the duration (in seconds) of a file
     */
    private function getDuration(Media $media)
    {
        $info = $this->id3->analyze($this->tempMediaDir . '/' . $media->filename);
        $time = $info['playtime_string'];
        $time = explode(':', $time);

        $hours = (count($time) == 3) ? $time[0] : 0;
        $mins = (count($time) > 1) ? $time[count($time) - 2] : 0;
        $secs = $time[count($time) - 1];

        $seconds = mktime($hours, $mins, $secs) - mktime(0, 0, 0);

        return $seconds;
    }

    /**
     * @throws UploadExistsException if the Media file is not unique
     */
    private function checkIfUnique(Media $media)
    {
        $exist = Media::query()->where('hash', $media->hash)->first();

        if ($exist) {
            throw new UploadExistsException("A file with the same hash is already in the database");
        }
    }

}
