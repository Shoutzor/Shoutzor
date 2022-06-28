<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Media extends Model
{
    use UsesUUID, HasFactory;

    const STORAGE_PATH = 'media/';
    public $timestamps = false;
    protected $table = 'media';
    protected $fillable = ['title', 'filename', 'hash', 'duration', 'is_video', 'image', 'source', 'album_id'];

    public function album()
    {
        return $this->belongsTo('App\Models\Album');
    }

    public function artists()
    {
        return $this->belongsToMany('App\Models\Artist');
    }

    public function getImageAttribute($value)
    {
        if(File::exists(storage_path($value))) {
            return $value;
        }

        return '/images/album_cover_placeholder.jpg';
    }
}
