<?php

namespace App;

use App\Events\Internal\ArtistCreateEvent;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Artist extends Model
{
    use UsesUUID, HasFactory;

    public static function create(Artist $artist)
    {
        $event = new ArtistCreateEvent($artist);
        app(EventDispatcher::class)->dispatch($event);

        //Check if the artist already exists
        if ($event->exists() === false) {
            $artist->save();
        }
    }

    public function albums()
    {
        return $this->belongsToMany('App\Album');
    }

    public function media()
    {
        return $this->belongsToMany('App\Media');
    }
}
