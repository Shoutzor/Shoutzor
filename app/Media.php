<?php

namespace App;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use UsesUUID, HasFactory;

    const STORAGE_PATH = 'media/';
    public $timestamps = false;
    protected $table = 'media';
    protected $fillable = ['title', 'filename', 'hash', 'duration', 'is_video', 'image', 'source', 'album_id'];

    public function album()
    {
        return $this->belongsTo('App\Album');
    }

    public function artists()
    {
        return $this->belongsToMany('App\Artist');
    }
}
