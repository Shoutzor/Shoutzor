<?php

use Phalcon\Models\Media;

interface PlayerHandler {

  public boolean play(Media $media);

}
