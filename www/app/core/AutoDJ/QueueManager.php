<?php

namespace Xorinzor\Shoutzor\AutoDJ;

use Shoutzor\Model\Media;
use Shoutzor\Model\Request;
use Shoutzor\Model\History;
use Shoutzor\Liquidsoap\Manager as LiquidsoapManager;

use Exception;

class QueueManager {

  public function getQueueList() {
    return Request::query()->related('media')->get();
  }

  public function getNextFromQueue() {
    return Request::query()->orderBy('id', 'ASC')->related('media')->first();
  }

  public function removeNextFromQueue() {
    $obj = $this->getNextFromQueue();

    if($obj !== null) {
      $obj->delete();
    }

    return true;
  }

  public function getQueueCount() {
    return Request::query()->count();
  }

  public function addToQueue(Media $media, $createRequest = true) {
    //Get the config options
    $config = App::module('shoutzor')->config('shoutzor');

    //Get the path to the file
    $filepath = $config['mediaDir'] . '/' . $media->filename;

    //Make sure the file is readable
    if (!is_readable($filepath)) {
      throw new Exception(__('Cannot read music file '.$filepath.', Permission denied.'));
    }

    //Add request to the playlist
    $liquidsoapManager = new LiquidsoapManager();
    $liquidsoapManager->queueTrack($filepath);

    if($createRequest === true) {
      //Save request in the database
      $request = Request::create();
      $request->save(array(
        'media_id'      => $media->id,
        'requester_id'  => App::user()->id,
        'requesttime'   => (new \DateTime())->format('Y-m-d H:i:s')
      ));
    }

    return true;
  }

  public function addToHistory(Media $media, $requester_id = null) {
    $request = History::create();
    $request->save(array(
      'media_id'      => $media->id,
      'requester_id'  => $requester_id,
      // 'played_at'     => (new \DateTime())->format('Y-m-d H:i:s')
    ));
  }

}
