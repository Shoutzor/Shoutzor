<?php

namespace Intervention\Image\Gd\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class GreyscaleCommand extends AbstractCommand
{
    /**
     * Turns an image into a greyscale version
     *
     * @param  Image  $image
     * @return boolean
     */
    public function execute($image)
    {
        return imagefilter($image->getCore(), IMG_FILTER_GRAYSCALE);
    }
}
