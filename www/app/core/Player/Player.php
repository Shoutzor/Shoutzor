<?php

namespace Shoutzor\Player;

use Shoutzor\Media\Media;
use Shoutzor\Provider\Provider;

interface Player {

    /**
    * Returns the name of this Player
    */
    public function getName() : string;

    /**
     * Returns the icon of this Player
     */
    public function getIcon() : string;

    /**
     * Checks if a Provider is supported by this Player
     * @param Provider $provider
     * @return bool
     */
    public function isProviderSupported(Provider $provider) : bool;

    /**
    * Returns the available & supported Providers for this Player
    */
    public function getProviders() : array;

    /**
     * Returns the Media object of the track that is currently playing
     * @return Media
     */
    public function getCurrentMedia() : Media;

    /**
     * Give the player the command to play
     * @param Media|null $media if media is provided, the player will switch to this media instantly
     * @return bool
     */
    public function play(Media $media = null) : bool;

    /**
     * Give the player the command to pause (or resume if already paused)
     * @return bool
     */
    public function pause() : bool;

    /**
     * Give the player the command to skip to the next track
     * @return bool
     */
    public function next() : bool;
}
