<?php

namespace App;

use App\Events\Internal\AlbumCreateEvent;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Album extends Model {
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function create(Album $album) {
        $event = new AlbumCreateEvent($album);
        app(EventDispatcher::class)->dispatch($event);

        //Check if the album already exists
        if($event->exists() === false) {
            $album->save();
        }
    }

    public function artists() {
        return $this->belongsToMany('App\Artist');
    }

    public function media() {
        return $this->belongsToMany('App\Media');
    }
}
