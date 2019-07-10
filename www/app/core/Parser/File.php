<?php

namespace Shoutzor\Parser;

use Phalcon\Config;

use Shoutzor\Model\Media;
use Shoutzor\Model\Artist;
use Shoutzor\Model\Album;
use Shoutzor\Model\ArtistMedia;
use Shoutzor\App\AcoustID;
use Shoutzor\App\LastFM;

use getID3;
use getid3_lib;
use getid3_writetags;
use Exception;

/**
 * TODO adapt this class to be part of a set of parsers following a standard.
 * This class will parse uploaded files (mp3, wav, etc).
 * Other parsers will parse youtube, spotify, etc. (not necessarily downloaded, but still.)
 */
class File {

    private $id3;
    private $lastfm;
    private $mediaDir;
    private $tempMediaDir;
    private $imageDir;

    private $config;

    public function __construct(Config $config)
    {
        $this->config       = $config;
        $this->id3          = new getID3();
        $this->lastfm       = new LastFM();
        $this->mediaDir     = $config->shoutzor->mediaDir;
        $this->tempMediaDir = $config->shoutzor->mediaDir . '/temp';
        $this->imageDir     = $config->shoutzor->imageDir;
    }

    public function getMediaDir()
    {
        return $this->mediaDir;
    }

    public function getTempMediaDir()
    {
        return $this->tempMediaDir;
    }

    public function parse(Media &$media)
    {
      switch($media->status)
      {
        case Media::STATUS_PROCESSING:  //If the file is already processing, we dont have to do this again.
        case Media::STATUS_FINISHED:    //If a media file is already finished there is no point in parsing it
        case Media::STATUS_ERROR:       //@TODO before we can start fixing media files with the ERROR status, we need to know what could go wrong that could be recoverable
          return $media->status;

        default:
          continue;
      }

      $media->crc = $this->calculateHash($this->getTempMediaDir() . '/' . $media->filename);

      //It's a duplicate, remove it and return the result code
      if($existing = $this->exists($media)) {
          //Remove the temporary file
          unlink($this->getTempMediaDir() . '/' . $media->filename);

          //Return the duplicate statuscode
          return Media::STATUS_DUPLICATE;
      }

      //Get the media file duration in seconds
      $media->duration = $this->getDuration($media);

      //If the duration is less than 30 seconds, its a bogus upload, deny it
      if($media->duration < 30)
      {
          return $media->status = Media::STATUS_DURATION_TOO_SHORT;
      }

      //If the duration exceeds our limit, return error
      if($media->duration > App::module('shoutzor')->config('shoutzor')['uploadDurationLimit'] * 60)
      {
          return $media->status = Media::STATUS_DURATION_TOO_LONG;
      }

      //Not a duplicate, move the file from the temp to the permanent directory.
      //Until a file finishes parsing completely, the file will never be moved to the permanent directory
      rename($this->getTempMediaDir() . '/' . $media->filename, $this->getMediaDir() . '/' . $media->filename);

      //Set the status of the media file to processing
      $media->save(['status' => Media::STATUS_PROCESSING]);

      //Create AcoustID instance
      $acoustid = new AcoustID();

      //get the metatags from the media file
      $defaultTags = $this->getID3Tags($media);
      $defaultTags['artist'] = array_column($defaultTags['artist'], 'name');
      $defaultTags['album'] = array_column($defaultTags['album'], 'title');

      $tags = $defaultTags;

      //Check if acoustID is enabled.
      if($this->config->modules->acoustid->enabled)
      {
          $newTags = $acoustid->getMediaInfo($this->getMediaDir() . '/' . $media->filename);

          if($newTags !== false)
          {
              //If no title was found, set the manually fetched title
              $tags['title'] = $newTags['title'] ?: $defaultTags['title'];

              //If no artist data was found, set the manually fetched artist data
              $tags['artist'] = $newTags['artist'] ?: $defaultTags['artist'];

              //If no album data was found, set the manually fetched album data
              $tags['album'] = $newTags['album'] ?: $defaultTags['album'];
          }
      }

      //Set the title of the media file
      $media->title = $tags['title'];
      $artists      = array();

      //Add artists for each track
      if(is_array($tags['artist'])) {
          foreach($tags['artist'] as $artist) {
              $artist = $this->addArtist($media, $artist);
              if(!is_null($artist) && $artist instanceof Artist) {
                  $artists[] = $artist;
              }
          }
      }

      //Add artists for each track
      if(is_array($tags['album'])) {
          foreach($tags['album'] as $album) {
              $this->addAlbum($media, $album, $artists);
          }
      }

      //Set the correct ID3 tags on the file
      $this->writeID3Tags($this->getMediaDir() . '/' . $media->filename, $tags['title'], implode(", ", $tags['artist']));

      //We're finished, set the status of the media file to finished
      $media->save(['status' => Media::STATUS_FINISHED]);

      //Return the finished statuscode
      return Media::STATUS_FINISHED;
    }

    public function addArtist(Media $media, $name)
    {
      $name = ucfirst(strtolower($name));
      $artist = Artist::query()->where('name = :name', ['name' => $name]);

      if($artist->count() > 0) {
          $artist = $artist->first();
      } else {
          $summary = '';
          $image   = '';

          //Check if the LastFM integration is enabled
          if($this->config->modules->lastfm->enabled)
          {
              $data = $this->lastfm->getArtistInfo($name);
              if($data === true) {
                  $summary = $data['bio']['summary'];
                  $image = $this->downloadImage($data['image']) ?: '';
              }
          }

          $artist = Artist::create();
          $artist->save([
              'name' => $name,
              'summary' => $summary,
              'image' => $image
          ]);
      }

      //Add the artist to the media
      $am = new ArtistMedia();
      $am->media_id   = $media->id;
      $am->artist_id  = $artist->id;
      $am->save();

      // $phql = "INSERT INTO artist_media (media_id, artist_id) VALUES (:mediaId:, :artistId:) ON DUPLICATE KEY UPDATE media_id=media_id";
      // $manager->executeQuery(
      //   $phql,
      //   [
      //       'mediaId'   => $media->id,
      //       'artistId'  => $artist->id
      // ]);

      return $artist;
    }

    public function addAlbum(Media $media, $title, $artists = array())
    {
      $title = ucfirst(strtolower($title));
      $album = Album::findFirst([
        'conditions'  => 'title = :title',
        'bind'  => [
          'title' => $title
          ]
      ]);

      if($album == false)
      {
          $summary  = '';
          $image    = '';

          if($this->config->modules->lastfm->enabled && !is_null($artists) && count($artists) > 0) {
              $data = $this->lastfm->getAlbumInfo($title, $artists[0]->name);
              $summary = $data['wiki']['summary'];
              $image = $this->downloadImage($data['image']) ?: '';
          }

          //Create the new album
          $album = new Album();
          $album->title   = $title;
          $album->summary = $summary;
          $album->image   = $image;
          $album->save();
      }

      //Add the media to the album
      $am = new AlbumMedia();
      $am->media_id = $media->id;
      $am->album_id = $album->id;
      $am->save();

      //Add the artists to the album
      foreach($artists as $artist) {
        $am = new AlbumArtist();
        $am->artist_id  = $artist->id;
        $am->album_id   = $album->id;
        $am->save();
      }
    }

    //TODO this needs to be moved to it's own class
    public function downloadImage($url)
    {
      if(empty($url)) {
          return false;
      }

      $destName = basename($url);
      $result = false;

      try {
          if(ini_get('allow_url_fopen')) {
              $result = @file_put_contents($this->imageDir . '/' . $destName, file_get_contents($url));
              if($result !== false) {
                  return $destName;
              }
          }

          //Either allow_url_fopen is disabled, or file_put_contents failed
          //Attempting cURL
          if($result === false) {
              $ch = curl_init($url);
              $fp = fopen($this->imageDir . '/'. $destName, 'wb');
              curl_setopt($ch, CURLOPT_FILE, $fp);
              curl_setopt($ch, CURLOPT_HEADER, 0);
              $result = curl_exec($ch);
              curl_close($ch);
              fclose($fp);
          }
      } catch(Exception $e) {
          $result = false;
      }

      return $result;
    }

    //TODO this needs to be moved to its own class
    public function getID3Tags(Media $media)
    {
      $this->id3->option_md5_data        = true;
      $this->id3->option_md5_data_source = true;

      // Analyze file
      $info = $this->id3->analyze($this->mediaDir . '/' . $media->filename);
      getid3_lib::CopyTagsToComments($info);

      //Default values
      $result = array(
        'title' 	=> $this->config->shoutzor->useFilenameIfUntitled == true ? preg_replace('/(^[^.]*.)|(\\.[^.\\s]{2,4}$)/', '', $media->filename) : 'Untitled',
        'artist' 	=> array(),
        'album' 	=> array()
      );

      //Check if any Tags are available
      if(isset($info['comments_html'])):
        //Get the media title
        if(isset($info['comments_html']['title']) && !empty($info['comments_html']['title'][0])):
          $result['title'] = ucwords(preg_replace("/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i", '', html_entity_decode(strtolower($info['comments_html']['title'][0]))));
        endif;

        //Get the artists
        if(isset($info['comments_html']['artist']) && is_array($info['comments_html']['artist'])):
          foreach($info['comments_html']['artist'] as $artist):
            $artist = preg_replace("/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i", '', $artist);
            $artist = preg_replace('/(\(\)|\[\])/', '', $artist);
            if(!empty($artist)):
              $artist = ucwords(html_entity_decode(strtolower($artist)));
              $artist = preg_split('/\s*(Feat\.|Vs\.|Ft\.)\s*/', $artist);
              $artist = implode(" /// ", $artist);
              $artist = preg_split('/\s*(&|Feat|Vs|Ft|\/\/\/)\s*/', $artist);
              foreach($artist as $a):
                $result['artist'][] = array(
                  'name' => html_entity_decode($a)
                );
              endforeach;
            endif;
          endforeach;
        endif;

        //Get the album titles
        if(isset($info['comments_html']['album']) && is_array($info['comments_html']['album'])):
          $a = 0;
          foreach($info['comments_html']['album'] as $album):
            $album = preg_replace("/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i", '', $album);
            $album = preg_replace('/(\(\)|\[\])/', '', $album);
            if(!empty($album)):
              $result['album'][] = array(
                'title' => html_entity_decode($album),
                'cover' => (isset($info['comments']['picture'][$a]['data'])) ? $info['comments']['picture'][$a]['data'] : null
              );
            endif;
            $a++;
          endforeach;
        endif;
      endif;

      return $result;
    }

    /**
     * Write ID3 Data to the specified file
     * TODO this needs to be moved to it's own class
     */
    public function writeID3Tags($file, $title, $artist)
    {
        $tagwriter = new getid3_writetags();
        $tagwriter->filename = '/path/to/file.mp3';
        $tagwriter->tagformats = array('id3v1', 'id3v2.3');

        // set various options (optional)
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = 'UTF-8';
        $tagwriter->remove_other_tags = true;

        if(!is_array($artist)) {
            $artist = array($artist);
        }

        $tagData = [
            'title' => array($title),
            'artist' => $artist
        ];

        //Add our new Tag Data
        $tagwriter->tag_data = $tagData;

        // write tags
        if ($tagwriter->WriteTags()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Checks if the provided instance is unique
     * TODO exists() method in the Media class?
     * @return false|Music
     */
    public function exists(Media $media)
    {
        $obj = Media::findFirst([
          'conditions' => 'crc = :crc: AND status = :status:',
          'bind' => [
            'crc'     => $media->crc,
            'status'  => Media::STATUS_FINISHED
          ]
        ]);

        return $obj ?: false;
    }

    /**
     * Calculates the hash of a file
     * TODO move to it's own class
     */
    public function calculateHash($file)
    {
        return hash_file('crc32', $file);
    }

    /**
     * Calculates the duration (in seconds) of a file
     * TODO move to it's own class
     */
    public function getDuration(Media $media)
    {
        $info = $this->id3->analyze($this->tempMediaDir . '/' . $media->filename);
        $time = $info['playtime_string'];
        $time = explode(':',$time);

        $hours = (count($time) == 3) ? $time[0] : 0;
        $mins = (count($time) > 1) ? $time[count($time)-2] : 0;
        $secs = $time[count($time)-1];

        $seconds = mktime($hours,$mins,$secs) - mktime(0,0,0);

        return $seconds;
    }

}
