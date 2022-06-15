<?php

namespace Intervention\Image\Gd\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;
use Intervention\Image\Size;

class GetSizeCommand extends AbstractCommand
{
    /**
     * Reads size of given image instance in pixels
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $this->setOutput(new Size(imagesx($image->getCore()), imagesy($image->getCore())));

        return true;
    }
}
