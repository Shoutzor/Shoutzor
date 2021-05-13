<?php

namespace Intervention\Image\Gd\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class BlurCommand extends AbstractCommand {
    /**
     * Applies blur effect on image
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image) {
        $amount = $this->argument(0)->between(0, 100)->value(1);

        for($i = 0; $i < intval($amount); $i++) {
            imagefilter($image->getCore(), IMG_FILTER_GAUSSIAN_BLUR);
        }

        return true;
    }
}
