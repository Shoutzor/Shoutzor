<?php

use Phalcon\Models\Media;

interface Handler {

  public boolean play(Media $media);

}
