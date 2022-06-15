<?php

namespace Intervention\Image\Filters;

use Intervention\Image\Image;

interface FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @param Image $image
     * @return Image
     */
    public function applyFilter(Image $image);
}
