<?php

namespace Intervention\Image\Imagick\Commands;

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

        return $image->getCore()->blurImage(1 * $amount, 0.5 * $amount);
    }
}
