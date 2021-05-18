<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {
    const STORAGE_PATH = 'media/';
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';
    protected $fillable = ['title', 'filename', 'crc', 'duration', 'is_video'];

    public function albums() {
        return $this->belongsToMany('App\Album');
    }

    public function artists() {
        return $this->belongsToMany('App\Artist');
    }
}
