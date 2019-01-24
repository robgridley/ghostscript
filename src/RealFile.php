<?php

namespace RobGridley\Ghostscript;

use RuntimeException;
use RobGridley\Ghostscript\Contracts\LocalFile;

class RealFile implements LocalFile
{
    /**
     * The path to the file.
     *
     * @var string
     */
    private $path;

    /**
     * Create a new real file instance.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new RuntimeException("The file [$path] does not exist");
        }

        $this->path = $path;
    }

    /**
     * Get the path to the local file.
     *
     * @return string
     */
    public function getLocalPath(): string
    {
        return $this->path;
    }
}
