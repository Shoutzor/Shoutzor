<?php

use Symfony\Component\Process\Process;

class AcoustID {

    private $enabled;
    private $appKey;
    private $requirementDir;

    public function __construct() {
        //$config = App::module('shoutzor')->config();

        $this->enabled = $config['acoustid']['enabled'] == 1;
        $this->appKey = $config['acoustid']['appKey'];
        $this->requirementDir = realpath($config['root_path'] . '/../shoutzor-requirements/acoustid');
    }

    public function isEnabled() {
        return $this->enabled;
    }

    public function getFileFingerprint($file) {
        $output = array();
        $returnCode = 0;

        //Make sure the file exists and is readable
        if(!file_exists($file) || !is_readable($file)) {
            return false;
        }

        $process = new Process($this->requirementDir . '/fpcalc ' . escapeshellarg($file));
        $process->run();

        //The return code is not 0 (success), return false
        if($returnCode !== 0) {
            return false;
        }

        $output = explode("\n", $process->getoutput());
        $result = array();
        foreach($output as $item) {
            if(empty($item)) continue;

            $temp = explode("=", $item);

            $result[strtolower($temp[0])] = $temp[1];
        }


        return $result;
    }

    public function lookup($duration, $fingerprint) {
        //Make sure AcoustID is enabled
        if($this->isEnabled() === false) {
            return false;
        }

        $url = 'http://api.acoustid.org/v2/lookup?client=' . $this->appKey;
        $url .= '&meta=compress+recordings+sources+releasegroups&duration=' . $duration;
        $url .= '&fingerprint=' . $fingerprint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if($response === false) {
            return false;
        }

        // If using JSON...
        $data = json_decode($response);

        //An error occured.
        if($data->status === "error") {
            //@TODO $data->error->message contains the error information, perhaps log it?
            return false;
        }

        //Make sure the results list is not empty (this happens when it cant identify the music)
        if(count($data->results) == 0) {
            return false;
        }

        //Just a double check to make sure this key exists.
        if(!isset($data->results[0]->recordings)) {
            return false;
        }

        //Make sure the matching score isn't too low
        if($data->results[0]->score < 0.5) {
            return false;
        }

        $data = $data->results[0]->recordings;

        if(count($data) == 0) {
            return false;
        }

        $highestScore = 0;
        $selectedKey = 0;

        foreach($data as $key=>$value) {
            if($value->sources > $highestScore) {
                $selectedKey = $key;
                $highestScore = $value->sources;
            }
        }

        $data = $data[$selectedKey];

        $info = array();

        //Get the media file title
        $info['title'] = isset($data->title) ? $data->title : false; //False means no-data for this tag.

        //Get the media file artists
        if(isset($data->artists)) {
            $info['artist'] = array();
            foreach($data->artists as $artist) {
                $info['artist'][] = $artist->name;
            }
        } else {
            //False means no-data for this tag.
            $info['artist'] = false;
        }

        //Get the media file albums
        //Make sure the group exists in the first element (best-match)
        if(isset($data->releasegroups)) {
            $info['album'] = array();
            foreach($data->releasegroups as $release) {
                if(!isset($release->type)) continue;
                if(strtolower($release->type) !== "album") continue;
                $info['album'][] = $release->title;
            }
        } else {
            //False means no-data for this tag.
            $info['album'] = false;
        }

        return $info;
    }

    public function getMediaInfo($filename) {
        //Check if AcoustID is enabled
        if($this->isEnabled() === false) {
            return false;
        }

        //Get the fingerprint from the media file
        $data = $this->getFileFingerprint($filename);

        //Errorchecking
        if($data === false || count($data) == 0) {
            return false;
        }

        //Get matching information for the provided fingerprint
        $data = $this->lookup($data['duration'], $data['fingerprint']);

        //Return the results
        return $data;
    }

}
