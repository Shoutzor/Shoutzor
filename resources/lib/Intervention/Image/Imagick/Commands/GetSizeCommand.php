<?php

namespace Intervention\Image\Imagick\Commands;

use Imagick;
use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;
use Intervention\Image\Size;

class GetSizeCommand extends AbstractCommand
{
    /**
     * Reads size of given image instance in pixels
     *
     * @param  Image  $image
     * @return boolean
     */
    public function execute($image)
    {
        /** @var Imagick $core */
        $core = $image->getCore();

        $this->setOutput(new Size($core->getImageWidth(), $core->getImageHeight()));

        return true;
    }
}
