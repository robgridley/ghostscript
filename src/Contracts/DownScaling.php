<?php

namespace RobGridley\Ghostscript\Contracts;

interface DownScaling
{
    /**
     * Get the down-scale factor.
     *
     * @return int
     */
    public function getDownScaleFactor(): int;
}
