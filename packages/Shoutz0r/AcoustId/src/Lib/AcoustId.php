<?php

namespace Shoutz0r\AcoustId\Lib;

use App\Media;
use App\Upload;
use Symfony\Component\Process\Process;

class AcoustId
{

    private string $appKey;
    private string $fpcalc_bin;
    private Media $media;
    private Upload $upload;

    public function __construct(string $appKey)
    {
        $this->appKey = $appKey;
        $this->fpcalc_bin = __DIR__.'../../resources/bin/fpcalc';
    }

    public function parse(Upload $upload, Media $media)
    {
        die("parsing!");

        $this->upload = $upload;
        $this->media = $media;

        //Get the fingerprint from the media file
        $fingerprint = $this->getFileFingerprint();

        //Error checking
        if ($fingerprint === false || count($fingerprint) == 0) {
            return false;
        }

        //Get matching information for the provided fingerprint
        $data = $this->parseFingerprint($fingerprint['duration'], $fingerprint['fingerprint']);

        //Return the results
        return true;
    }

    public function getFileFingerprint()
    {
        $returnCode = 0;

        $process = new Process([$this->fpcalc_bin, escapeshellarg($this->media->filename)]);
        $process->run();

        //The return code is not 0 (success), return false
        if ($returnCode !== 0) {
            return false;
        }

        $output = explode("\n", $process->getoutput());
        $result = array();

        foreach ($output as $item) {
            if (empty($item)) {
                continue;
            }

            $temp = explode("=", $item);
            $result[strtolower($temp[0])] = $temp[1];
        }

        return $result;
    }

    public function parseFingerprint($duration, $fingerprint)
    {
        $url = 'http://api.acoustid.org/v2/lookup?client='.$this->appKey;
        $url .= '&meta=compress+recordings+sources+releasegroups&duration='.$duration;
        $url .= '&fingerprint='.$fingerprint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if ($response === false) {
            return false;
        }

        $data = json_decode($response);

        //An error occured.
        if ($data->status === "error") {
            //@TODO $data->error->message contains the error information, perhaps log it?
            return false;
        }

        //Make sure the results list is not empty (this happens when it cant identify the music)
        if (count($data->results) == 0) {
            return false;
        }

        //Just a double check to make sure this key exists.
        if (!isset($data->results[0]->recordings)) {
            return false;
        }

        //Make sure the matching score isn't too low
        if ($data->results[0]->score < 0.5) {
            return false;
        }

        $data = $data->results[0]->recordings;

        if (count($data) == 0) {
            return false;
        }

        $highestScore = 0;
        $selectedKey = 0;

        //Grab the highest scoring result from the resultset
        foreach ($data as $key => $value) {
            if ($value->sources > $highestScore) {
                $selectedKey = $key;
                $highestScore = $value->sources;
            }
        }

        $data = $data[$selectedKey];

        //Set the media title
        if (isset($data->title)) {
            $this->media->title = $data->title;
        }

        //Get the media file artists
        if (isset($data->artists)) {
            foreach ($data->artists as $artist) {
                //@todo Emit ArtistCreateEvent
            }
        }

        //Get the media file albums
        //Make sure the group exists in the first element (best-match)
        if (isset($data->releasegroups)) {
            foreach ($data->releasegroups as $release) {
                if (!isset($release->type)) {
                    continue;
                }

                if (strtolower($release->type) !== "album") {
                    continue;
                }

                //@todo Emit AlbumCreateEvent
            }
        }

        return true;
    }

}
