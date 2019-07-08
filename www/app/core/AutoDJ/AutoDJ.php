<?php
namespace Shoutzor\AutoDJ;

use Shoutzor\Model\Media;
use Shoutzor\Model\Request;
use Shoutzor\Model\History;

use DateTime;
use DateInterval;

class AutoDJ {
    private $queueManager;

    public function __construct() {
        $this->queueManager = new QueueManager();
    }

    public function importQueue() {
        if($this->queueManager->getQueueCount() > 0) {
            $queue = $this->queueManager->getQueueList();
            foreach($queue as $request) {
                $this->queueManager->addToQueue($request->media, false);
            }
        }
        $this->checkQueue();
    }

    /**
     * Move the queue along to the next track
     */
    public function playNext() {
        //Add the current item to the history
        $item = $this->queueManager->getNextFromQueue();
        if($item !== null) {
            $this->queueManager->addToHistory($item->media, $item->requester_id);
        }
        //Remove the next first item from the queue
        $this->queueManager->removeNextFromQueue();
        //Make sure there are enough items left in the queue, if not, we have to step in and add some
        $this->checkQueue();
    }

    /**
     * Make sure there is always at least 1 song in queue
     */
    private function checkQueue() {
        $queueCount = $this->queueManager->getQueueCount();
        //Shoutzor needs at least 2 songs for crossfading, so we need to make sure there is always at least 1 song queued
        if($queueCount == 0) {
            $this->queueManager->addToQueue($this->getRandomTrack());
        }
    }


    /**
     * Pick a random track from the database with cooldowns for recently played tracks and artists
     * @param $autoForce bool whether to automatically force a random track if no results are returned
     * @param $force bool force a random track straight away if true
     */
    public function getRandomTrack($autoForce = true, $forced = false) {
        if($forced === true) {
            return Media::query()->orderBy('rand()')->first();
        } else {
            $list = array();
        }

        $config = App::module('shoutzor')->config('shoutzor');
        $requestHistoryTime = (new DateTime())->sub(new DateInterval('PT'.$config['mediaRequestDelay'].'M'))->format('Y-m-d H:i:s');
        $artistHistoryTime = (new DateTime())->sub(new DateInterval('PT'.$config['artistRequestDelay'].'M'))->format('Y-m-d H:i:s');

        //Build a list of media id's that are available to play, next, randomly pick one
        $q = Media::query()
        ->select('DISTINCT m.*')
        ->from('@shoutzor_media m')
        ->leftJoin('@shoutzor_requestlist q', 'q.media_id = m.id')
        ->where('q.media_id IS NULL') //Exclude all media_id's that are in already in queue
        //Get all Media_id's that have recently been played and exclude those too
        ->where('m.id NOT IN (
                  SELECT h.media_id
                  FROM @shoutzor_history h
                  LEFT JOIN @shoutzor_requestlist tq ON tq.media_id = h.media_id
                  WHERE h.played_at > :maxTime
                )', ['maxTime' => $requestHistoryTime])
       //Next, get all Media_id's related to the artists that have recently been played (or are queued right now) and exclude those too
        ->where('m.id NOT IN (
                  SELECT tma.media_id
                  FROM @shoutzor_media_artist tma
                  WHERE tma.artist_id IN (
                    SELECT ma.artist_id
                    FROM @shoutzor_media_artist ma
                    WHERE ma.media_id IN (
                      SELECT th.media_id
                      FROM @shoutzor_history th
                      LEFT JOIN @shoutzor_requestlist tq ON tq.media_id = th.media_id
                      WHERE th.played_at > :maxTime
                )))', ['maxTime' => $artistHistoryTime])
        ->groupBy('m.id')
        ->orderBy('rand('.microtime(true).')');
        if($q->count() === 0) {
            return ($autoForce === true) ? $this->getRandomTrack(true, true) : false;
        }
        return $q->first();
    }
}
