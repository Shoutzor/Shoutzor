<?php

namespace App\Processors;

use App\Exceptions\MediaDuplicateException;
use App\Exceptions\MediaPropertyMissingException;
use App\Exceptions\UploadFileMissingException;
use App\Models\Media;
use App\Models\Upload;
use getID3;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadProcessor
{

    private getID3 $id3;

    public function __construct()
    {
        $this->id3 = new getID3();
    }

    /**
     * @throws MediaDuplicateException
     */
    public function parse(Upload $upload)
    {
        $uploadFile = storage_path('app/' . Upload::STORAGE_PATH . $upload->filename);
        if(!file_exists($uploadFile)) {
            throw new UploadFileMissingException("$uploadFile could not be found");
        }

        //Create the base media object
        $media = $this->createBaseMediaObject($upload);

        # Calculate the hash of the file
        $media->hash = hash_file('sha512', $uploadFile);

        // Check if another media file with the same hash already exists
        // This is just a very, very basic and quick way to check if an identical file already exists
        // For better duplicate detection we need to implement fingerprinting.
        $this->checkIfUnique($media);

        $id3info = $this->id3->analyze($uploadFile);

        # Get the duration of the file
        $media->duration = $this->getDuration($id3info);

        # Iterate over tags, return the resulting array
        $id3tags = $this->parseTags($id3info);

        if(!array_key_exists('title', $id3tags)) {
            throw new MediaPropertyMissingException("could not determine title of media file");
        }

        $media->title = $id3tags['title'][0];

        // Move the media file from the temp upload directory to its persistent directory
        Storage::copy(
            Upload::STORAGE_PATH . $upload->filename,
            Media::STORAGE_PATH . $media->filename
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
        return new Media([
            'title' => '',
            'filename' => $upload->filename,
            'duration' => 0,
            'is_video' => false
        ]);
    }

    /**
     * Calculates the duration (in seconds) of a file
     */
    private function getDuration(array $id3info): int
    {
        $time = $id3info['playtime_string'];
        $time = explode(':', $time);

        $hours = (count($time) == 3) ? $time[0] : 0;
        $minutes = (count($time) > 1) ? $time[count($time) - 2] : 0;
        $secs = $time[count($time) - 1];

        return mktime($hours, $minutes, $secs) - mktime(0, 0, 0);
    }

    private function parseTags(array $id3info): array
    {
        $result = [];

        if(array_key_exists('tags', $id3info)) {
            $result = array_values($id3info['tags'])[0];
        }

        return $result;
    }

    /**
     * @throws MediaDuplicateException if the Media file is not unique
     */
    private function checkIfUnique(Media $media)
    {
        $exist = Media::query()->where('hash', $media->hash)->first();

        if ($exist) {
            throw new MediaDuplicateException("A media file with the same hash is already in the database");
        }
    }

}
