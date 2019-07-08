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

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray([], []);
    }
}
