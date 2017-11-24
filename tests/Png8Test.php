<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\Png8;
use RobGridley\Ghostscript\Contracts\Device;

class Png8Test extends TestCase
{
    public function testDevice()
    {
        $device = new Png8;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertEquals('-sDEVICE=png256', $device->getArguments());
    }
}
