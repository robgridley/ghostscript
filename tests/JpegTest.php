<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\Jpeg;
use RobGridley\Ghostscript\Contracts\Device;

class JpegTest extends TestCase
{
    public function testDevice()
    {
        $device = new Jpeg;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertEquals('-sDEVICE=jpeg -dJPEGQ=0', $device->getArguments());
    }

    public function testSetQuality()
    {
        $device = new Jpeg;
        $device->setQuality(85);
        $this->assertEquals('-sDEVICE=jpeg -dJPEGQ=85', $device->getArguments());
    }

    public function testSetQualityTooHigh()
    {
        $device = new Jpeg;
        $this->expectException(InvalidArgumentException::class);
        $device->setQuality(101);
    }

    public function testSetQualityTooLow()
    {
        $device = new Jpeg;
        $this->expectException(InvalidArgumentException::class);
        $device->setQuality(-1);
    }
}
