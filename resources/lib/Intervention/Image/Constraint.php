<?php

namespace Intervention\Image;

class Constraint
{
    /**
     * Bit value of aspect ratio constraint
     */
    const ASPECTRATIO = 1;

    /**
     * Bit value of upsize constraint
     */
    const UPSIZE = 2;

    /**
     * Constraint size
     *
     * @var Size
     */
    private $size;

    /**
     * Integer value of fixed parameters
     *
     * @var int
     */
    private $fixed = 0;

    /**
     * Create a new constraint based on size
     *
     * @param  Size  $size
     */
    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    /**
     * Returns current size of constraint
     *
     * @return Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Checks if given argument is fixed in current constraint
     *
     * @param  int  $type
     * @return boolean
     */
    public function isFixed($type)
    {
        return (bool) ($this->fixed & (1 << $type));
    }

    /**
     * Fixes aspect ratio in current constraint
     *
     * @return void
     */
    public function aspectRatio()
    {
        $this->fix(self::ASPECTRATIO);
    }

    /**
     * Fix the given argument in current constraint
     *
     * @param  int  $type
     * @return void
     */
    public function fix($type)
    {
        $this->fixed = ($this->fixed & ~(1 << $type)) | (1 << $type);
    }

    /**
     * Fixes possibility to size up in current constraint
     *
     * @return void
     */
    public function upsize()
    {
        $this->fix(self::UPSIZE);
    }
}
