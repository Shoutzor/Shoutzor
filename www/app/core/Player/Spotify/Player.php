<?php

namespace Shoutzor\Player\Spotify;

use Shoutzor\Player\Media;
use Shoutzor\Player\Player as IPlayer;
use Shoutzor\Provider\Provider;

class Player implements IPlayer {

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    /**
     * @inheritDoc
     */
    public function isProviderSupported(Provider $provider): bool
    {
        // TODO: Implement isProviderSupported() method.
    }

    /**
     * @inheritDoc
     */
    public function getProviders(): array
    {
        // TODO: Implement getProviders() method.
    }

    /**
     * @inheritDoc
     */
    public function play(Media $media = null): bool
    {
        // TODO: Implement play() method.
    }
}