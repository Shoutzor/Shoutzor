<?php

namespace Intervention\Image\Gd\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class GammaCommand extends AbstractCommand
{
    /**
     * Applies gamma correction to a given image
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $gamma = $this->argument(0)->type('numeric')->required()->value();

        return imagegammacorrect($image->getCore(), 1, $gamma);
    }
}
