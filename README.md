# Ghostscript PHP

Yet another Ghostscript PHP wrapper for converting PDFs (or PS files) to images. This library accepts strings, streams or real files as input and returns the output from stdout as a string.

## Installation

```
composer require robgridley/ghostscript:dev-master
```

## Usage Example

```php
use RobGridley\Ghostscript\Devices;
use RobGridley\Ghostscript\RealFile;
use RobGridley\Ghostscript\Ghostscript;
use RobGridley\Ghostscript\VirtualFile;

$device = new Devices\Png24;
$device->setDownScaleFactor(2);

$gs = new Ghostscript($device);
$gs->setPageBox('trim');
$gs->setResolution(144);

$file = new RealFile('/path/to/file.pdf');
// or $file = new VirtualFile($someString);

$image = $gs->convert($file);
```
