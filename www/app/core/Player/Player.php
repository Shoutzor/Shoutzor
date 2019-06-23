<?php

namespace Shoutzor\Player;

use Shoutzor\Provider\Provider;

interface Player {

  /**
   * Returns the name of this Player
   */
  public string getName();

  /**
   * Checks if a Provider is supported by this Player
   */
  public boolean isProviderSupported(Provider $provider);

  /**
   * Returns the available & supported Providers for this Player
   */
  public array getProviders();

}
