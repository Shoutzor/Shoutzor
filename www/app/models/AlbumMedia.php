<?php

namespace Shoutzor\Model;

class AlbumMedia extends Model
{

  public $id;
  public $album_id;
  public $media_id;

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
      'media_id',
      Media::class,
      'id',
      [
        'reusable' => true
      ]
    );
  }
}
