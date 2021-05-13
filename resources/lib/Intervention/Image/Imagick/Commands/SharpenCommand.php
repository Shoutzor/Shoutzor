<?php

namespace Intervention\Image\Imagick\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class SharpenCommand extends AbstractCommand {
    /**
     * Sharpen image
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image) {
        $amount = $this->argument(0)->between(0, 100)->value(10);

        return $image->getCore()->unsharpMaskImage(1, 1, $amount / 6.25, 0);
    }
}
