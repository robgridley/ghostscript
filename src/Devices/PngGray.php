<?php

namespace RobGridley\Ghostscript\Devices;

use RobGridley\Ghostscript\Contracts\DownScaling;

class PngGray extends Png implements DownScaling
{
    use DownScaleFactor;

    /**
     * The output device.
     *
     * @var string
     */
    protected $device = 'pnggray';
}
