<?php

namespace RobGridley\Ghostscript\Devices;

use RobGridley\Ghostscript\Contracts\DownScaling;

class Png24 extends Png implements DownScaling
{
    use DownScaleFactor;

    /**
     * The output device.
     *
     * @var string
     */
    protected $device = 'png16m';
}
