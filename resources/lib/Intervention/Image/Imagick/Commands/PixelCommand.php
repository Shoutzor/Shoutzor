<?php

namespace Intervention\Image\Imagick\Commands;

use ImagickDraw;
use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;
use Intervention\Image\Imagick\Color;

class PixelCommand extends AbstractCommand
{
    /**
     * Draws one pixel to a given image
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $color = $this->argument(0)->required()->value();
        $color = new Color($color);
        $x = $this->argument(1)->type('digit')->required()->value();
        $y = $this->argument(2)->type('digit')->required()->value();

        // prepare pixel
        $draw = new ImagickDraw;
        $draw->setFillColor($color->getPixel());
        $draw->point($x, $y);

        // apply pixel
        return $image->getCore()->drawImage($draw);
    }
}
