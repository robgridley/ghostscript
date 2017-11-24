<?php

namespace RobGridley\Ghostscript\Devices;

use RobGridley\Ghostscript\Contracts\Device;

abstract class Png implements Device
{
    /**
     * Get the command arguments.
     *
     * @return string
     */
    public function getArguments(): string
    {
        $arguments[] = sprintf('-sDEVICE=%s', $this->device);

        if (isset($this->backgroundColor)) {
            $arguments[] = sprintf('-dBackgroundColor=%s', $this->backgroundColor);
        }

        if (isset($this->downScaleFactor)) {
            $arguments[] = sprintf('-dDownScaleFactor=%d', $this->downScaleFactor);
        }

        return implode(' ', $arguments);
    }
}
