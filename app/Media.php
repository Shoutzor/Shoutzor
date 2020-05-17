<?php

namespace Shoutzor\Model;

use Phalcon\Mvc\Model;

class Media extends Model {

    /* song pending processing */
    const STATUS_UPLOADED = 0;

    /* song is beeing processed */
    const STATUS_PROCESSING = 1;

    /* song has successfully been processed */
    const STATUS_FINISHED = 2;

    /* an error occured during any of the previous steps */
    const STATUS_ERROR = 3;

    /* This song has already been uploaded */
    const STATUS_DUPLICATE = 4;

    /* The duration of this song exceeds the limit configured */
    const STATUS_DURATION_TOO_LONG = 5;

    /* The duration of this song is less than 30 seconds, ie: bogus upload */
    const STATUS_DURATION_TOO_SHORT = 6;

    /**
     * @Primary
     * @Identity
     * @Column(type="integer")
     */
    public $id;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $filename;

    /** @Column(type="integer") */
    public $uploader_id;

    /** @Column(type="integer") */
    public $status;

    /** @Column(type="datetime") */
    public $created;

    /** @Column(type="string") */
    public $crc;

    /** @Column(type="integer") */
    public $duration;

    //Dirty fix - Field for SiteController - History::played_at
    public $played_at;

    public function initialize() {
      $this->hasManyToMany(
        'id',
        AlbumMedia::class,
        'media_id',
        'album_id',
        Album::class,
        'id'
      );

      $this->hasManyToMany(
        'id',
        ArtistMedia::class,
        'media_id',
        'artist_id',
        Artist::class,
        'id'
      );

      $this->belongsTo('uploader_id',   User::class,    'id');
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_UPLOADED => __('Uploaded'),
            self::STATUS_PROCESSING => __('Processing'),
            self::STATUS_FINISHED => __('Finished'),
            self::STATUS_ERROR => __('Error')
        ];
    }

    public function getStatusText()
    {
        $statuses = self::getStatuses();

        return isset($statuses[$this->status]) ? $statuses[$this->status] : __('Unknown');
    }

    public static function getHistory() {
      $resultset = $this->modelsManager->createBuilder()
                    ->columns([
                      'm'         => 'm.*',
                      'played_at' => 'h.played_at'
                    ])
                    ->addFrom(Media::class, 'm')
                    ->leftJoin(History::class, 'h.media_id = m.id', 'h')
                    ->where('h.media_id = m.id')
                    ->orderBy('h.played_at DESC')
                    ->limit(5)
                    ->getQuery()
                    ->execute();

      //TODO only return one type of instance in the array, ie: only History[]

      return $resultset;
    }

    public static function getNowplaying() {
      $resultset = $this->modelsManager->createBuilder()
                      ->columns([
                        'played_at' => 'h.played_at'
                      ])
                      ->addFrom(Media::class, 'm')
                      ->leftJoin(History::class, 'h.media_id = m.id', 'h')
                      ->where('h.media_id = m.id')
                      ->orderBy('h.played_at DESC')
                      ->limit(1)
                      ->getQuery()
                      ->execute();

        return $resultset[0];
    }

    /**
     * Checks if the artist is currently in the request-queue
     */
    public static function isRequested($id): bool
    {
      $result = Request::findFirst([
        'constraints' => 'media_id = :media:',
        'bind' => [
          'media' => $id
        ]
      ]);

      return ($result ?: false);
    }

    public static function isRecentlyPlayed($id, $maxTimeAgo) {
      $resultset = $this->modelsManager->createBuilder()
                    ->addFrom(History::class, 'h')
                    ->where('media_id = :id: AND played_at > :maxTime:')
                    ->getQuery()
                    ->execute(['id' => $id, 'maxTimeAgo' => $maxTimeAgo]);

      return count($resultset) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = $this->toArray([], []);

        $data['artist'] = array();
        if(!is_null($this->artist)) {
            foreach($this->artist as $artist) {
                $data['artist'][] = $artist->jsonSerialize();
            }
        }

        $data['album'] = array();
        if(!is_null($this->album)) {
            foreach($this->album as $album) {
                $data['album'][] = $album->jsonSerialize();
            }
        }

        return $data;
    }
}
