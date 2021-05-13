<?php

namespace Intervention\Image\Gd\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class ContrastCommand extends AbstractCommand {
    /**
     * Changes contrast of image
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image) {
        $level = $this->argument(0)->between(-100, 100)->required()->value();

        return imagefilter($image->getCore(), IMG_FILTER_CONTRAST, ($level * -1));
    }
}
