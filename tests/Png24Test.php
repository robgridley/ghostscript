<?php

use PHPUnit\Framework\TestCase;
use RobGridley\Ghostscript\Devices\Png24;
use RobGridley\Ghostscript\Contracts\Device;
use RobGridley\Ghostscript\Contracts\DownScaling;

class Png24Test extends TestCase
{
    public function testDevice()
    {
        $device = new Png24;
        $this->assertInstanceOf(Device::class, $device);
        $this->assertInstanceOf(DownScaling::class, $device);
        $this->assertEquals(['-sDEVICE=png16m', '-dDownScaleFactor=1'], $device->getArguments());
    }

    public function testSetDownScaleFactor()
    {
        $device = new Png24;
        $device->setDownScaleFactor(8);
        $this->assertEquals(['-sDEVICE=png16m', '-dDownScaleFactor=8'], $device->getArguments());
    }

    public function testSetDownScaleFactorTooHigh()
    {
        $device = new Png24;
        $this->expectException(InvalidArgumentException::class);
        $device->setDownScaleFactor(9);
    }

    public function testSetDownScaleFactorTooLow()
    {
        $device = new Png24;
        $this->expectException(InvalidArgumentException::class);
        $device->setDownScaleFactor(0);
    }
}
