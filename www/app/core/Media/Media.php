<?php

namespace Shoutzor\Provider;

abstract class Media {
    protected Provider $provider;
    protected bool $isLocal;
    protected string $location;
    protected string $title;
    protected array $author;
    protected array $formats;
}
