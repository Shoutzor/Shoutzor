<?php

namespace Modules\ShoutzorAcoustId\App;

class AcoustId {

    public function __construct() {
    }

    public function getFileFingerprint($file) {
        $returnCode = 0;

        //TODO find a way of neatly getting the module resources path

        $process = new Process(Module::getAssetsPath() . '/fpcalc ' . escapeshellarg($file));
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
        $url = 'http://api.acoustid.org/v2/lookup?client=' . config('ShoutzorAcoustId.appkey');
        $url .= '&meta=compress+recordings+sources+releasegroups&duration=' . $duration;
        $url .= '&fingerprint=' . $fingerprint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if($response === false) {
            return false;
        }

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

        //Grab the highest scoring result from the resultset
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
