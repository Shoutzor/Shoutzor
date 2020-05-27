<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

abstract class MediaSource implements Arrayable, Jsonable
{
    /**
     * The identifier of the MediaSource, ie: file, youtube, spotify, etc.
     * Once defined this should not be changed as this will be used in the database.
     * @var string
     */
    const identifier = 'invalid';

    /**
     * The fontawesome icon that should be displayed for this source in the coming-up component
     * this array will be passed to the font-awesome-icon component
     * @var array
     */
    const icon = ['fas', 'question'];

    public function toArray()
    {
        return [
            'identifier' => static::identifier,
            'icon'       => static::icon
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }
}
