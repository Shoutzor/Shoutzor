<?php

namespace Shoutzor\Model;

use Phalcon\Mvc\Model;

class Request extends Model {

    /**
     * @Primary
     * @Identity
     * @Column(type="integer")
     */
    public $id;

    /** @Column(type="integer") @Media_id */
    public $media_id;

    /** @Column(type="integer") @Requester_id */
    public $requester_id;

    /** @Column(type="datetime") */
    public $requesttime;

    public function initialize() {
      $this->belongsTo('media_id',      Media::class, 'id');
      $this->belongsTo('requester_id',  User::class,  'id');
    }

    public static function getQueued() {
      $resultset = $this->modelsManager->createBuilder()
                    ->addFrom(Media::class, 'm')
                    ->leftJoin(Request::class, 'r.media_id = m.id', 'r')
                    ->where('r.media_id = m.id')
                    ->orderBy('r.id ASC')
                    ->getQuery()
                    ->execute();

      //TODO only return one type of instance in the array, ie: only Request[]

      return $queued;
    }
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray([], []);
    }
}
