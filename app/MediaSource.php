<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class MediaSource implements Arrayable, Jsonable
{
    /**
     * The identifier of the MediaSource, ie: file, youtube, spotify, etc.
     * Once defined this should not be changed as this will be used in the database.
     * @var string
     */
    public string $identifier;

    /**
     * The fontawesome icon that should be displayed for this source in the coming-up component
     * this array will be passed to the font-awesome-icon component
     * @var array
     */
    public array $icon = ['fas', 'question'];

    public function toArray()
    {
        return [
            'identifier' => $this->identifier,
            'icon'       => $this->icon
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }
}
