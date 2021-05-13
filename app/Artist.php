<?php

namespace App;

use App\Events\Internal\ArtistCreateEvent;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Artist extends Model {

    public static function create(Artist $artist) {
        $event = new ArtistCreateEvent($artist);
        app(EventDispatcher::class)->dispatch($event);

        //Check if the artist already exists
        if($event->exists() === false) {
            $artist->save();
        }
    }

    public function albums() {
        return $this->belongsToMany('App\Album');
    }

    public function media() {
        return $this->belongsToMany('App\Media');
    }
}
