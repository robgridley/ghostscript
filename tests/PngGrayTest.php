<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\PngGray;
use RobGridley\Ghostscript\Contracts\Device;
use RobGridley\Ghostscript\Contracts\DownScaling;

class PngGrayTest extends TestCase
{
    public function testDevice()
    {
        $device = new PngGray;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertInstanceOf(DownScaling::class, $device);
        $this->assertEquals('-sDEVICE=pnggray -dDownScaleFactor=1', $device->getArguments());
    }

    public function testSetDownScaleFactor()
    {
        $device = new PngGray;
        $device->setDownScaleFactor(8);
        $this->assertEquals('-sDEVICE=pnggray -dDownScaleFactor=8', $device->getArguments());
    }

    public function testSetDownScaleFactorTooHigh()
    {
        $device = new PngGray;
        $this->expectException(InvalidArgumentException::class);
        $device->setDownScaleFactor(9);
    }

    public function testSetDownScaleFactorTooLow()
    {
        $device = new PngGray;
        $this->expectException(InvalidArgumentException::class);
        $device->setDownScaleFactor(0);
    }
}
