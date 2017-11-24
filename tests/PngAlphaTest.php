<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\PngAlpha;
use RobGridley\Ghostscript\Contracts\Device;
use RobGridley\Ghostscript\Contracts\DownScaling;

class PngAlphaTest extends TestCase
{
    public function testDevice()
    {
        $device = new PngAlpha;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertInstanceOf(DownScaling::class, $device);
        $this->assertEquals('-sDEVICE=pngalpha -dDownScaleFactor=1', $device->getArguments());
    }

    public function testSetDownScaleFactor()
    {
        $device = new PngAlpha;
        $device->setDownScaleFactor(8);
        $this->assertEquals('-sDEVICE=pngalpha -dDownScaleFactor=8', $device->getArguments());
    }

    public function testSetDownScaleFactorTooHigh()
    {
        $device = new PngAlpha;
        $this->expectException(InvalidArgumentException::class);
        $device->setDownScaleFactor(9);
    }

    public function testSetDownScaleFactorTooLow()
    {
        $device = new PngAlpha;
        $this->expectException(InvalidArgumentException::class);
        $device->setDownScaleFactor(0);
    }

    public function testSetBackgroundColor()
    {
        $device = new PngAlpha;
        $device->setBackgroundColor('0000ff');
        $this->assertEquals('-sDEVICE=pngalpha -dBackgroundColor=16#0000ff -dDownScaleFactor=1', $device->getArguments());
    }
}
