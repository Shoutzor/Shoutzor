<?php

namespace App\Models;

use App\Events\Internal\AlbumCreateEvent;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Album extends Model
{
    use UsesUUID, HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function create(Album $album)
    {
        $event = new AlbumCreateEvent($album);
        app(EventDispatcher::class)->dispatch($event);
        $album->save();
    }

    public function artists()
    {
        return $this->hasManyThrough('App\Models\Artist', 'App\Models\Media', 'media_id', 'album_id', 'album_id', '');
    }

    public function media()
    {
        return $this->hasMany('App\Models\Media');
    }
}
