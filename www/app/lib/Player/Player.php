<?php

namespace Shoutzor\Player;

use Shoutzor\Provider\Provider;

interface Player {

  public string getName();

  public boolean isProviderSupported(Provider $provider);
  public array getSupportedProviders();

}
