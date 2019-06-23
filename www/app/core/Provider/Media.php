<?php

namespace Shoutzor\Provider;

interface Media {

  public Provider $provider;

  public boolean $isLocal;
  public string $location;

  public string $title;
  public array $author;

  public array $formats;

}
