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

    const STORAGE_PATH = 'media/';

    protected $fillable = [
        'title', 'filename', 'crc', 'duration', 'is_video'
    ];

    public function albums() {
        return $this->belongsToMany('App\Album');
    }

    public function artists() {
        return $this->belongsToMany('App\Artist');
    }

    public function isValid() : bool {
        return false;
        //TODO implement validation method
/*        return Validator::make($this, [
            'title'     => 'required|max:255',
            'filename'  => 'required|unique',
            'crc'       => 'required|unique',
            'duration'  => 'required|digits|gt:0',
            'is_video'  => 'required|boolean'
        ])->passes();*/
    }
}
