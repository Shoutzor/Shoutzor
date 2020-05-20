<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function artists() {
        return $this->belongsToMany('App\Artist');
    }

    public function media() {
        return $this->belongsToMany('App\Media');
    }
}
