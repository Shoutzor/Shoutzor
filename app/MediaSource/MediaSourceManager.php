<?php

namespace App\MediaSource;

use App\Exceptions\MediaSourceDuplicateException;

class MediaSourceManager
{
    private array $source;

    public function __construct()
    {
        $this->source = [];
    }

    /**
     * Adds the provided MediaSource
     * Shoutz0r uses this to know which files can be played,
     * as well as show the correct information for the file details (front-end)
     *
     * @param MediaSource $source
     * @throws MediaSourceDuplicateException
     */
    public function registerSource(MediaSource $source): void
    {
        if (array_key_exists($source->getIdentifier(), $this->source)) {
            throw new MediaSourceDuplicateException("MediaSource with the identifier '{$source->getIdentifier()}' already exists");
        }

        $this->source[$source->getIdentifier()] = $source;
    }

    /**
     * Returns the matching MediaSource object for the provided identifier
     * will return null if unregistered
     * @param string $identifier
     * @return MediaSource|null
     */
    public function getSource(string $identifier): ?MediaSource
    {
        return $this->source[$identifier];
    }

    /**
     * Returns an array of all currently registered MediaSource objects
     * @return array
     */
    public function getSources(): array
    {
        return $this->source;
    }

    /**
     * Returns an array of all currently registered MediaSource arrays
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->getSources() as $s) {
            $result[] = $s->toArray();
        }

        return $result;
    }
}
