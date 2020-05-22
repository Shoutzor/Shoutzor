<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaSource
{
    /**
     * The identifier of the MediaSource, ie: file, youtube, spotify, etc.
     * Once defined this should not be changed as this will be used for the index.
     * @var string
     */
    public string $identifier;

    /**
     * The fontawesome icon that should be displayed for this source in the coming-up component
     * this array will be passed to the font-awesome-icon component
     * @var array
     */
    public array $icon;
}
