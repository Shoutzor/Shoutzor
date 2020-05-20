<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{

    public function albums() {
        return $this->belongsToMany('App\Album');
    }

    public function media() {
        return $this->belongsToMany('App\Media');
    }

}
