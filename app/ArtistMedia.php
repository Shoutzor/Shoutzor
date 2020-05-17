<?php

namespace Shoutzor\Model;

class ArtistMedia extends Model
{

  public $id;
  public $artist_id;
  public $media_id;

  public function initialize()
  {
    $this->belongsTo(
      'artist_id',
      Artist::class,
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
