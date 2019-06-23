<?php

namespace Shoutzor\Converter;

use Shoutzor\Provider\Media as ProviderMedia;

class Converter {

  /**
   * Initialize the converter with the specified media
   */
  public function __construct(ProviderMedia $media) {

  }

  /**
   * Checks if the provided media is able to be converted
   */
  public boolean canConvert() {
  }

  /**
   * (attempt to) convert the media to MP3
   */
  public function convert() {
  }

}
