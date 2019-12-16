<?php

namespace Shoutzor\Media;

interface Media {
/*    protected Provider $provider;
    protected bool $isLocal;
    protected string $location;
    protected string $title;
    protected array $author;
    protected array $formats;*/

    /**
     * This returns a Shoutzor\Player\Player specific identifier that can be used to open & play the media
     * ie: a spotify-uri, localfile-path, youtube-url.
     * @return string
     */
    public function getPlayerSpecificIdentifier() : string;
}
