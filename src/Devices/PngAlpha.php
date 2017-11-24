<?php

namespace RobGridley\Ghostscript\Devices;

use InvalidArgumentException;
use RobGridley\Ghostscript\Contracts\DownScaling;

class PngAlpha extends Png implements DownScaling
{
    use DownScaleFactor;

    /**
     * The output device.
     *
     * @var string
     */
    protected $device = 'pngalpha';

    /**
     * The background colour.
     *
     * @var string|null
     */
    protected $backgroundColor;

    /**
     * Set the background colour to the specified hex value.
     *
     * @param string $value
     */
    public function setBackgroundColor(string $value)
    {
        $value = ltrim($value, '#');

        if (!preg_match('/^[a-f0-9]{6}$/i', $value)) {
            throw new InvalidArgumentException('Invalid hex value');
        }

        $this->backgroundColor = '16#' . $value;
    }
}
