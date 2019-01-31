<?php

namespace RobGridley\Ghostscript\Contracts;

interface Device
{
    /**
     * Get the command arguments.
     *
     * @return array
     */
    public function getArguments(): array;
}
