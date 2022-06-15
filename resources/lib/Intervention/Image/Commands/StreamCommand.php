<?php

namespace Intervention\Image\Commands;

use Intervention\Image\Image;
use function GuzzleHttp\Psr7\stream_for;

class StreamCommand extends AbstractCommand
{
    /**
     * Builds PSR7 stream based on image data. Method uses Guzzle PSR7
     * implementation as easiest choice.
     *
     * @param Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $format = $this->argument(0)->value();
        $quality = $this->argument(1)->between(0, 100)->value();

        $this->setOutput(stream_for($image->encode($format, $quality)->getEncoded()));

        return true;
    }
}
