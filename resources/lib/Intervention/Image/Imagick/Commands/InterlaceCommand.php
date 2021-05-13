<?php

namespace Intervention\Image\Imagick\Commands;

use Imagick;
use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class InterlaceCommand extends AbstractCommand {
    /**
     * Toggles interlaced encoding mode
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image) {
        $mode = $this->argument(0)->type('bool')->value(true);

        if($mode) {
            $mode = Imagick::INTERLACE_LINE;
        }
        else {
            $mode = Imagick::INTERLACE_NO;
        }

        $image->getCore()->setInterlaceScheme($mode);

        return true;
    }
}
