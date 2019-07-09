<?php

namespace Shoutzor\Model;

class AlbumArtist extends Model
{

  public $id;
  public $album_id;
  public $artist_id;

  public function initialize()
  {
    $this->belongsTo(
      'album_id',
      Album::class,
      'id',
      [
        'reusable' => true
      ]
    );

    $this->belongsTo(
      'artist_id',
      Artist::class,
      'id',
      [
        'reusable' => true
      ]
    );
  }
}
