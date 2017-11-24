<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\JpegGray;
use RobGridley\Ghostscript\Contracts\Device;

class JpegGrayTest extends TestCase
{
    public function testDevice()
    {
        $device = new JpegGray;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertEquals('-sDEVICE=jpeggray -dJPEGQ=0', $device->getArguments());
    }

    public function testSetQuality()
    {
        $device = new JpegGray;
        $device->setQuality(85);
        $this->assertEquals('-sDEVICE=jpeggray -dJPEGQ=85', $device->getArguments());
    }

    public function testSetQualityTooHigh()
    {
        $device = new JpegGray;
        $this->expectException(InvalidArgumentException::class);
        $device->setQuality(101);
    }

    public function testSetQualityTooLow()
    {
        $device = new JpegGray;
        $this->expectException(InvalidArgumentException::class);
        $device->setQuality(-1);
    }
}
