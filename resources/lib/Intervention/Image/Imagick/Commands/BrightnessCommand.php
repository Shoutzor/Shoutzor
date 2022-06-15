<?php

namespace Intervention\Image\Imagick\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class BrightnessCommand extends AbstractCommand
{
    /**
     * Changes image brightness
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $level = $this->argument(0)->between(-100, 100)->required()->value();

        return $image->getCore()->modulateImage(100 + $level, 100, 100);
    }
}
