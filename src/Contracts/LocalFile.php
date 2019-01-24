<?php

namespace RobGridley\Ghostscript\Contracts;

interface LocalFile
{
    /**
     * Get the local path to the file.
     *
     * @return string
     */
    public function getLocalPath(): string;
}
