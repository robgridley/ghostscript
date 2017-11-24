<?php

namespace RobGridley\Ghostscript\Contracts;

interface Device
{
    /**
     * Get the command arguments.
     *
     * @return string
     */
    public function getArguments(): string;
}
