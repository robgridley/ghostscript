<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\Png4;
use RobGridley\Ghostscript\Contracts\Device;

class Png4Test extends TestCase
{
    public function testDevice()
    {
        $device = new Png4;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertEquals('-sDEVICE=png16', $device->getArguments());
    }
}
