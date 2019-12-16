<?php

namespace Shoutzor\Player\Spotify;

use Shoutzor\Media\Media;
use Shoutzor\Media\Spotify\SpotifySong;
use Shoutzor\Player\Player as IPlayer;
use Shoutzor\Provider\Provider;
use Shoutzor\Provider\Spotify\Provider as SpotifyProvider;

class Player implements IPlayer {

    private const SP_SCRIPT = APP_PATH . DS . 'bin' . DS . 'sp' . DS . 'sp.sh';
    private Media $currentMedia;

    private function runCommand($command) {
        return exec(self::SP_SCRIPT . ' ' . $command);
    }

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
    public function getCurrentMedia(): Media
    {
        return $this->currentMedia;
    }

    /**
     * @inheritDoc
     */
    public function play(Media $media = null): bool
    {
        //If the Media object is null, fetch the track from the playlist
        if(is_null($media)) {

        }
        //The spotify player supports only it's own media objects, any others will be searched for in the library
        elseif($media instanceof SpotifySong === false) {
        }
        //Valid Media object
        else {
            $this->currentMedia = $media;
        }

        $this->runCommand('open ' . $this->currentMedia->getPlayerSpecificIdentifier());
    }

    /**
     * @inheritDoc
     */
    public function pause(): bool
    {
        //Sends the "play/pause" command
        return $this->runCommand('pause');
    }

    /**
     * @inheritDoc
     */
    public function next(): bool
    {
        //Sends the "next" command
        return $this->runCommand('next');
    }

}