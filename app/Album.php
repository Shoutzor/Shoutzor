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

    public function initialize() {
      $this->hasManyToMany(
        'id',
        AlbumArtist::class,
        'album_id',
        'artist_id',
        Artist::class,
        'id'
      );

      $this->hasManyToMany(
        'id',
        AlbumMedia::class,
        'album_id',
        'media_id',
        Media::class,
        'id'
      );
    }

    /**
     * Returns all media related to this album
     */
    public function getMedia() {
      $resultset = $this->modelsManager->createBuilder()
        ->addFrom(Media::class, 'm')
        ->leftJoin(AlbumMedia::class, 'am.album_id = :albumId:', 'am')
        ->where('m.id = am.media_id')
        ->orderBy('m.title ASC')
        ->getQuery()
        ->execute(['albumId' => $this->id]);

      return array_column($resultset, 'm');
    }

    /**
     * {@inheritdoc}
     */
     public function jsonSerialize() {
         $data = $this->toArray([], []);
         //$data['url'] = App::url('@shoutzor/album/view', ['id' => $this->id]);

         return $data;
     }
}
