<?php

namespace Shoutzor\Model;

use Phalcon\Mvc\Model;

class Album extends Model {

    use ModelTrait;

    /**
     * @Primary
     * @Identity
     * @Column(type="integer")
     */
    public $id;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $summary;

    /** @Column(type="string") */
    public $image;

    public $artists_id;
    public $media_id;

    public function initialize() {
      $this->belongsTo('artists_id',    Artist::class,  'id');
      $this->belongsTo('media_id',      Media::class,   'id');
    }

    public function getMedia() {
        $topTracks = Media::query()
                        ->select('m.*')
                        ->from('@shoutzor_media m')
                        ->leftJoin('@shoutzor_media_album ma', 'ma.album_id = '.$this->id)
                        ->where('m.id = ma.media_id')
                        ->orderBy('m.title', 'ASC')
                        ->related(['artist', 'album'])
                        ->get();

        return $topTracks;
    }

    /**
     * {@inheritdoc}
     */
     public function jsonSerialize() {
         $data = $this->toArray([], []);
         $data['url'] = App::url('@shoutzor/album/view', ['id' => $this->id]);

         return $data;
     }
}
