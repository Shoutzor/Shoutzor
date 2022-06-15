<?php

namespace Intervention\Image\Imagick\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class GreyscaleCommand extends AbstractCommand
{
    /**
     * Turns an image into a greyscale version
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image)
    {
        return $image->getCore()->modulateImage(100, 0, 100);
    }
}
