<?php

use Phalcon\Models\Media;

interface Handler {

  public Media getMedia($id, $attributes = array());

  public Media search($query, $filter = array())

}
