<?php

use Phalcon\Models\Media;

interface ProviderHandler {

  public Media getMedia($id, $attributes = array());

  public Media search($query, $filter = array())

}
