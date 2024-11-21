<?php

namespace RobGridley\Ghostscript;

use RobGridley\Ghostscript\Contracts\LocalFile;
use RuntimeException;

class VirtualFile implements LocalFile
{
    /**
     * The path to the temp file.
     *
     * @var string
     */
    private $path;

    /**
     * Create a new temp file instance.
     *
     * @param string|array|resource|null $data
     */
    public function __construct($data = null)
    {
        if (false === $path = tempnam(sys_get_temp_dir(), 'gs')) {
            throw new RuntimeException('Failed to create the temp file');
        }

        if (!is_null($data)) {
            if (false === file_put_contents($path, $data)) {
                throw new RuntimeException('Failed to write data to the temp file');
            }
        }

        $this->path = $path;
    }

    /**
     * Handle the temp file's destruction.
     */
    public function __destruct()
    {
        @unlink($this->path);
    }

    /**
     * Get the path to the temp file.
     *
     * @return string
     */
    public function getLocalPath(): string
    {
        return $this->path;
    }
}
