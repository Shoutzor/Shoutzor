<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    const STORAGE_PATH = 'media/';
    public $timestamps = false;
    protected $table = 'media';
    protected $fillable = ['title', 'filename', 'hash', 'duration', 'is_video', 'image', 'source'];

    public function albums()
    {
        return $this->belongsToMany('App\Album');
    }

    public function artists()
    {
        return $this->belongsToMany('App\Artist');
    }
}
