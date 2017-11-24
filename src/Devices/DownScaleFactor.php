<?php

namespace RobGridley\Ghostscript\Devices;

use InvalidArgumentException;

trait DownScaleFactor
{
    /**
     * The down-scale factor.
     *
     * @var int
     */
    protected $downScaleFactor = 1;

    /**
     * Set the down-scale factor.
     *
     * @param int $factor
     */
    public function setDownScaleFactor(int $factor)
    {
        if ($factor < 1 || $factor > 8) {
            throw new InvalidArgumentException('Down-scale factor must be between 1 and 8');
        }

        $this->downScaleFactor = $factor;
    }

    /**
     * Get the down-scale factor.
     *
     * @return int
     */
    public function getDownScaleFactor(): int
    {
        return $this->downScaleFactor;
    }
}
