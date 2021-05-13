<?php

namespace Intervention\Image;

use Exception;
use GuzzleHttp\Psr7\Stream;
use Imagick;
use Intervention\Image\Exception\NotReadableException;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

abstract class AbstractDecoder {
    /**
     * Buffer of input data
     *
     * @var mixed
     */
    private $data;

    /**
     * Creates new Decoder with data
     *
     * @param mixed $data
     */
    public function __construct($data = null) {
        $this->data = $data;
    }

    /**
     * Determines if current data is Symfony UploadedFile component
     *
     * @return boolean
     */
    public function isSymfonyUpload() {
        return is_a($this->data, 'Symfony\Component\HttpFoundation\File\UploadedFile');
    }

    /**
     * Initiates new image from mixed data
     *
     * @param mixed $data
     * @return Image
     */
    public function init($data) {
        $this->data = $data;

        switch(true) {

            case $this->isGdResource():
                return $this->initFromGdResource($this->data);

            case $this->isImagick():
                return $this->initFromImagick($this->data);

            case $this->isInterventionImage():
                return $this->initFromInterventionImage($this->data);

            case $this->isSplFileInfo():
                return $this->initFromPath($this->data->getRealPath());

            case $this->isBinary():
                return $this->initFromBinary($this->data);

            case $this->isUrl():
                return $this->initFromUrl($this->data);

            case $this->isStream():
                return $this->initFromStream($this->data);

            case $this->isDataUrl():
                return $this->initFromBinary($this->decodeDataUrl($this->data));

            case $this->isFilePath():
                return $this->initFromPath($this->data);

            // isBase64 has to be after isFilePath to prevent false positives
            case $this->isBase64():
                return $this->initFromBinary(base64_decode($this->data));

            default:
                throw new NotReadableException("Image source not readable");
        }
    }

    /**
     * Determines if current source data is GD resource
     *
     * @return boolean
     */
    public function isGdResource() {
        if(is_resource($this->data)) {
            return (get_resource_type($this->data) == 'gd');
        }

        return false;
    }

    /**
     * Initiates new image from GD resource
     *
     * @param Resource $resource
     * @return Image
     */
    abstract public function initFromGdResource($resource);

    /**
     * Determines if current source data is Imagick object
     *
     * @return boolean
     */
    public function isImagick() {
        return is_a($this->data, 'Imagick');
    }

    /**
     * Initiates new image from Imagick object
     *
     * @param Imagick $object
     * @return Image
     */
    abstract public function initFromImagick(Imagick $object);

    /**
     * Determines if current source data is Intervention\Image\Image object
     *
     * @return boolean
     */
    public function isInterventionImage() {
        return is_a($this->data, '\Intervention\Image\Image');
    }

    /**
     * Initiates new Image from Intervention\Image\Image
     *
     * @param Image $object
     * @return Image
     */
    public function initFromInterventionImage($object) {
        return $object;
    }

    /**
     * Determines if current data is SplFileInfo object
     *
     * @return boolean
     */
    public function isSplFileInfo() {
        return is_a($this->data, 'SplFileInfo');
    }

    /**
     * Initiates new image from path in filesystem
     *
     * @param string $path
     * @return Image
     */
    abstract public function initFromPath($path);

    /**
     * Determines if current source data is binary data
     *
     * @return boolean
     */
    public function isBinary() {
        if(is_string($this->data)) {
            $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $this->data);
            return (substr($mime, 0, 4) != 'text' && $mime != 'application/x-empty');
        }

        return false;
    }

    /**
     * Initiates new image from binary data
     *
     * @param string $data
     * @return Image
     */
    abstract public function initFromBinary($data);

    /**
     * Determines if current source data is url
     *
     * @return boolean
     */
    public function isUrl() {
        return (bool)filter_var($this->data, FILTER_VALIDATE_URL);
    }

    /**
     * Init from given URL
     *
     * @param string $url
     * @return Image
     */
    public function initFromUrl($url) {

        $options = ['http' => ['method' => "GET", 'header' => "Accept-language: en\r\n" . "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2\r\n"]];

        $context = stream_context_create($options);

        if($data = @file_get_contents($url, false, $context)) {
            return $this->initFromBinary($data);
        }

        throw new NotReadableException("Unable to init from given url (" . $url . ").");
    }

    /**
     * Determines if current source data is a stream resource
     *
     * @return boolean
     */
    public function isStream() {
        if($this->data instanceof StreamInterface) {
            return true;
        }
        if(!is_resource($this->data)) {
            return false;
        }
        if(get_resource_type($this->data) !== 'stream') {
            return false;
        }

        return true;
    }

    /**
     * Init from given stream
     *
     * @param StreamInterface|resource $stream
     * @return Image
     */
    public function initFromStream($stream) {
        if(!$stream instanceof StreamInterface) {
            $stream = new Stream($stream);
        }

        try {
            $offset = $stream->tell();
        }
        catch(RuntimeException $e) {
            $offset = 0;
        }

        $shouldAndCanSeek = $offset !== 0 && $stream->isSeekable();

        if($shouldAndCanSeek) {
            $stream->rewind();
        }

        try {
            $data = $stream->getContents();
        }
        catch(RuntimeException $e) {
            $data = null;
        }

        if($shouldAndCanSeek) {
            $stream->seek($offset);
        }

        if($data) {
            return $this->initFromBinary($data);
        }

        throw new NotReadableException("Unable to init from given stream");
    }

    /**
     * Determines if current source data is data-url
     *
     * @return boolean
     */
    public function isDataUrl() {
        $data = $this->decodeDataUrl($this->data);

        return is_null($data) ? false : true;
    }

    /**
     * Parses and decodes binary image data from data-url
     *
     * @param string $data_url
     * @return string
     */
    private function decodeDataUrl($data_url) {
        if(!is_string($data_url)) {
            return null;
        }

        $pattern = "/^data:(?:image\/[a-zA-Z\-\.]+)(?:charset=\".+\")?;base64,(?P<data>.+)$/";
        preg_match($pattern, $data_url, $matches);

        if(is_array($matches) && array_key_exists('data', $matches)) {
            return base64_decode($matches['data']);
        }

        return null;
    }

    /**
     * Determines if current source data is file path
     *
     * @return boolean
     */
    public function isFilePath() {
        if(is_string($this->data)) {
            try {
                return is_file($this->data);
            }
            catch(Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Determines if current source data is base64 encoded
     *
     * @return boolean
     */
    public function isBase64() {
        if(!is_string($this->data)) {
            return false;
        }

        return base64_encode(base64_decode($this->data)) === str_replace(["\n", "\r"], '', $this->data);
    }

    /**
     * Decoder object transforms to string source data
     *
     * @return string
     */
    public function __toString() {
        return (string)$this->data;
    }
}
