<?php

namespace Shoutzor\Player\Spotify;

use Shoutzor\Player\Media;
use Shoutzor\Player\Player as IPlayer;
use Shoutzor\Provider\Provider;
use Shoutzor\Provider\Spotify\Provider as SpotifyProvider;

class Player implements IPlayer {

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "Spotify";
    }

    /**
     * @inheritDoc
     */
    public function getIcon(): string
    {
        return "fa-spotify";
    }

    /**
     * @inheritDoc
     */
    public function isProviderSupported(Provider $provider): bool
    {
        return $provider instanceof SpotifyProvider;
    }

    /**
     * @inheritDoc
     */
    public function getProviders(): array
    {
        return [
            SpotifyProvider::class
        ];
    }

    /**
     * @inheritDoc
     */
    public function play(Media $media = null): bool
    {
        // TODO: Implement play() method.
    }

}