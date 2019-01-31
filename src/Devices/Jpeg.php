<?php

namespace RobGridley\Ghostscript\Devices;

use InvalidArgumentException;
use RobGridley\Ghostscript\Contracts\Device;

class Jpeg implements Device
{
    /**
     * The output device.
     *
     * @var string
     */
    protected $device = 'jpeg';

    /**
     * The JPEG DCT quantization level.
     *
     * @var int|null
     */
    protected $quality = 0;

    /**
     * Set the JPEG quality to the specified level.
     *
     * @param int $level
     */
    public function setQuality(int $level)
    {
        if ($level < 0 || $level > 100) {
            throw new InvalidArgumentException('Quality level must be between 0 and 100');
        }

        $this->quality = $level;
    }

    /**
     * Get the command arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return [
            "-sDEVICE={$this->device}",
            "-dJPEGQ={$this->quality}",
        ];
    }
}
