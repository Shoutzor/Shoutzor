<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';
    public $timestamps = false;

    public function getSourceAttribute() : ?MediaSource {
        return MediaSources::getInstance()->getSource($this->attributes['source']);
    }

    public function albums() {
        return $this->belongsToMany('App\Album');
    }

    public function artists() {
        return $this->belongsToMany('App\Artist');
    }
}
