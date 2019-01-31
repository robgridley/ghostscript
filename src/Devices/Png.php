<?php

namespace RobGridley\Ghostscript\Devices;

use RobGridley\Ghostscript\Contracts\Device;

abstract class Png implements Device
{
    /**
     * Get the command arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        $arguments[] = "-sDEVICE={$this->device}";

        if (isset($this->backgroundColor)) {
            $arguments[] = "-dBackgroundColor={$this->backgroundColor}";
        }

        if (isset($this->downScaleFactor)) {
            $arguments[] = "-dDownScaleFactor={$this->downScaleFactor}";
        }

        return $arguments;
    }
}
