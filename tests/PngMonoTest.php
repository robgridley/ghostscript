<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\PngMono;
use RobGridley\Ghostscript\Contracts\Device;

class PngMonoTest extends TestCase
{
    public function testDevice()
    {
        $device = new PngMono;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertEquals('-sDEVICE=pngmono', $device->getArguments());
    }
}
