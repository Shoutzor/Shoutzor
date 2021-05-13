<?php

namespace Intervention\Image\Imagick\Commands;

use Imagick;
use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class OpacityCommand extends AbstractCommand {
    /**
     * Defines opacity of an image
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image) {
        $transparency = $this->argument(0)->between(0, 100)->required()->value();

        $transparency = $transparency > 0 ? (100 / $transparency) : 1000;

        return $image->getCore()->evaluateImage(Imagick::EVALUATE_DIVIDE, $transparency, Imagick::CHANNEL_ALPHA);
    }
}
