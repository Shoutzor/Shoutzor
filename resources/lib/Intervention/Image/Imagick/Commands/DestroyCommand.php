<?php

namespace Intervention\Image\Imagick\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Image;

class DestroyCommand extends AbstractCommand
{
    /**
     * Destroys current image core and frees up memory
     *
     * @param  Image  $image
     * @return boolean
     */
    public function execute($image)
    {
        // destroy image core
        $image->getCore()->clear();

        // destroy backups
        foreach ($image->getBackups() as $backup) {
            $backup->clear();
        }

        return true;
    }
}
