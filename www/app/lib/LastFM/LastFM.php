<?php

class LastFM {

    private $enabled;
    private $appKey;
    private $secret;

    const API_URL = 'http://ws.audioscrobbler.com/2.0/';

    public function __construct() {
        $this->appKey = $config['apikey'];
        $this->secret = $config['secret'];
    }

    public function getArtistInfo($artist) {
        //Make the API call and fetch the data
        $result = $this->apiCall('artist.getinfo', ['artist' => $artist]);

        if($result === false) {
            return false;
        }

        //If an error occured, return false
        if(isset($result['error']) || !isset($result['artist'])) {
            return false;
        }

        $result = $result['artist'];

        //Remove unneeded values
        if(isset($result['stats'])) unset($result['stats']);
        if(isset($result['similar'])) unset($result['similar']);
        if(isset($result['tags'])) unset($result['tags']);

        //Make sure required values are always set though
        if(!isset($result['bio'])) $result['bio'] = array();
        if(!isset($result['bio']['summary'])) $result['bio']['summary'] = '';
        if(!isset($result['image'])) $result['image'] = array();

        $images = array();

        //Build our own associative array of images and their sizes
        foreach($result['image'] as $image) {
            if(!isset($image['size'])) continue;
            $images[$image['size']] = $image['#text'];
        }

        //Try to get the most suitable size picture
        if(isset($images['large'])) {
            $result['image'] = $images['large'];
        }
        elseif(isset($images['medium'])) {
            $result['image'] = $images['medium'];
        }
        elseif(isset($images['extralarge'])) {
            $result['image'] = $images['extralarge'];
        }
        elseif(isset($images['mega'])) {
            $result['image'] = $images['mega'];
        }
        else {
            //Size small is too small to be usable
            $result['image'] = '';
        }

        return $result;
    }

    public function getAlbumInfo($album, $artist) {
        //Make the API call and fetch the data
        $result = $this->apiCall('album.getinfo', ['artist' => $artist, 'album' => $album]);

        if($result === false) {
            return false;
        }

        //If an error occured, return false
        if(isset($result['error']) || !isset($result['album'])) {
            return false;
        }

        $result = $result['album'];

        //Remove unneeded values
        if(isset($result['listeners'])) unset($result['listeners']);
        if(isset($result['playcount'])) unset($result['playcount']);
        if(isset($result['tracks'])) unset($result['tracks']);
        if(isset($result['tags'])) unset($result['tags']);

        //Make sure required values are always set though
        if(!isset($result['wiki'])) $result['wiki'] = array('summary' => '');
        if(!isset($result['wiki']['summary'])) $result['wiki']['summary'] = '';
        if(!isset($result['image'])) $result['image'] = array();

        $images = array();

        //Build our own associative array of images and their sizes
        foreach($result['image'] as $image) {
            if(!isset($image['size'])) continue;
            $images[$image['size']] = $image['#text'];
        }

        //Try to get the most suitable size picture
        if(isset($images['large'])) {
            $result['image'] = $images['large'];
        }
        elseif(isset($images['medium'])) {
            $result['image'] = $images['medium'];
        }
        elseif(isset($images['extralarge'])) {
            $result['image'] = $images['extralarge'];
        }
        elseif(isset($images['mega'])) {
            $result['image'] = $images['mega'];
        }
        else {
            //Size small is too small to be usable
            $result['image'] = '';
        }

        return $result;
    }

    private function apiCall($method, $params) {
        //Create a base url
        $url = self::API_URL . '?method=' . $method . '&format=json' . '&api_key=' . $this->appKey;

        //Add other parameters to the url
        foreach($params as $key=>$value) {
            $url .= '&' . $key . '=' . $value;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if($response === false) {
            return false;
        }

        // If using JSON...
        $data = json_decode($response, true);

        return $data;
    }
}
