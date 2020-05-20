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



    public function albums() {
        return $this->belongsToMany('App\Album');
    }

    public function artists() {
        return $this->belongsToMany('App\Artist');
    }
}
