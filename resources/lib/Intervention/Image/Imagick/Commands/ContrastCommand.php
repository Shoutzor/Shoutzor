<?php

namespace Intervention\Image\Imagick\Commands;

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

        return $image->getCore()->sigmoidalContrastImage($level > 0, $level / 4, 0);
    }
}
