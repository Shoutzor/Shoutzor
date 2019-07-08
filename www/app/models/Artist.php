<?php

namespace Shoutzor\Model;

use Phalcon\Mvc\Model;

class Artist extends Model {

    /**
     * @Primary
     * @Identity
     * @Column(type="integer")
     */
    public $id;

    /** @Column(type="string") */
    public $name;

    /** @Column(type="string") */
    public $summary;

    /** @Column(type="string") */
    public $image;

    public $media_id;
    public $albums_id;

    public function initialize() {
      $this->belongsTo('albums_id',    Album::class,  'id');
      $this->belongsTo('media_id',     Media::class,   'id');
    }

    public function getTopMedia() {
        $topTracks = Media::query()
                        ->select('DISTINCT m.*, COUNT(h.id) as popularity, h.played_at as played_at')
                        ->from('@shoutzor_media m')
                        ->leftJoin('@shoutzor_media_artist ma', 'ma.artist_id = '.$this->id)
                        ->leftJoin('@shoutzor_history h', 'h.media_id = m.id')
                        ->where('m.id = ma.media_id')
                        ->groupBy('m.id')
                        ->orderBy('popularity', 'DESC')
                        ->limit(5)
                        ->related(['artist', 'album'])
                        ->get();

        //SELECT m.*, COUNT(h.id) as popularity, h.played_at as played_at FROM pk_shoutzor_media m LEFT JOIN pk_shoutzor_media_artist ma ON ma.artist_id = 1 LEFT JOIN pk_shoutzor_history h ON h.media_id = m.id WHERE m.id = ma.media_id ORDER BY popularity, m.title DESC LIMIT 5


        return $topTracks;
    }

    public function getAlbums() {
        $albums = Album::query()
                        ->leftJoin('@shoutzor_artist_album aa', 'aa.artist_id = '.$this->id)
                        ->where('id = aa.album_id')
                        ->related('artist')
                        ->get();

        return $albums;
    }

    public static function isRecentlyPlayed($id, $canRequestDateTime) {
        $q = Media::query()
                    ->select('m.id')
                    ->from('@shoutzor_media m')
                    ->where('(m.id IN (SELECT h.media_id FROM @shoutzor_history h WHERE h.media_id IN (SELECT tma.media_id FROM @shoutzor_media_artist tma WHERE tma.artist_id IN (SELECT ttma.artist_id FROM @shoutzor_media_artist ttma WHERE ttma.media_id = :id)) AND h.played_at > :maxTime)) OR (m.id IN (SELECT q.media_id FROM @shoutzor_requestlist q WHERE q.media_id IN (SELECT tma.media_id FROM @shoutzor_media_artist tma WHERE tma.artist_id IN (SELECT ttma.artist_id FROM @shoutzor_media_artist ttma WHERE ttma.media_id = :id))))', ['id' => $id, 'maxTime' => $canRequestDateTime]);

        return $q->count() == 0 ? false : true;
    }

    /**
     * {@inheritdoc}
     */
     public function jsonSerialize() {
         $data = $this->toArray([], []);
         $data['url'] = App::url('@shoutzor/artist/view', ['id' => $this->id]);

         return $data;
     }
}
