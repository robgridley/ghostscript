<?php

namespace RobGridley\Ghostscript;

use Symfony\Component\Process\Process;
use RobGridley\Ghostscript\Contracts\Device;
use RobGridley\Ghostscript\Contracts\LocalFile;
use RobGridley\Ghostscript\Contracts\DownScaling;

class Ghostscript
{
    const ANTIALIASING_NONE = 1;
    const ANTIALIASING_LOW = 2;
    const ANTIALIASING_HIGH = 4;

    /**
     * The path to the Ghostscript binary.
     *
     * @var string
     */
    protected $path = 'gs';

    /**
     * The process timeout in seconds.
     *
     * @var int
     */
    protected $timeout = 60;

    /**
     * The output device.
     *
     * @var Device
     */
    protected $device;

    /**
     * The sub-sampling box size for text.
     *
     * @var int
     */
    protected $textAntiAliasing = self::ANTIALIASING_HIGH;

    /**
     * The sub-sampling box size for graphics.
     *
     * @var int
     */
    protected $graphicsAntiAliasing = self::ANTIALIASING_HIGH;

    /**
     * The page box.
     *
     * @var string|null
     */
    protected $pageBox;

    /**
     * The output resolution.
     *
     * @var int
     */
    protected $resolution = 72;

    /**
     * The fixed output size.
     *
     * @var array|null
     */
    protected $fitPage;

    /**
     * Create a new Ghostscript instance.
     *
     * @param Device $device
     */
    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    /**
     * Set the path to the Ghostscript binary.
     *
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * Set the process timeout.
     *
     * @param int $seconds
     */
    public function setTimeout(int $seconds)
    {
        $this->timeout = $seconds;
    }

    /**
     * Set the page box.
     *
     * @param string $box
     */
    public function setPageBox(string $box)
    {
        switch ($box) {
            case 'bleed':
            case 'trim':
            case 'art':
            case 'crop':
                $this->pageBox = ucfirst($box) . 'Box';
                break;
            default:
                $this->pageBox = null;
        }
    }

    /**
     * Set the text anti-aliasing level.
     *
     * @param int $level
     */
    public function setTextAntiAliasing(int $level)
    {
        $this->textAntiAliasing = $level;
    }

    /**
     * Set the graphics anti-aliasing level.
     *
     * @param int $level
     */
    public function setGraphicsAntiAliasing(int $level)
    {
        $this->graphicsAntiAliasing = $level;
    }

    /**
     * Set the anti-aliasing level for both text and graphics.
     *
     * @param int $level
     */
    public function setAntiAliasing(int $level)
    {
        $this->setTextAntiAliasing($level);
        $this->setGraphicsAntiAliasing($level);
    }

    /**
     * Set the output resolution.
     *
     * @param int $ppi
     */
    public function setResolution(int $ppi)
    {
        $this->resolution = $ppi;
    }

    /**
     * Set the fixed output size (in points).
     *
     * @param int $width
     * @param int $height
     */
    public function setFitPage(int $width, int $height)
    {
        $this->fitPage = compact('width', 'height');
    }

    /**
     * Convert the specified PDF to an image.
     *
     * @param LocalFile $file
     * @param int $page
     * @return string
     */
    public function convert(LocalFile $file, int $page = 1): string
    {
        $command[] = $this->path;
        array_push($command, ...$this->device->getArguments());

        $command[] = "-dFirstPage=$page";
        $command[] = "-dLastPage=$page";
        $command[] = "-dGraphicsAlphaBits={$this->graphicsAntiAliasing}";
        $command[] = "-dTextAlphaBits={$this->textAntiAliasing}";
        $command[] = '-r' . $this->getResolution();

        if (!is_null($this->fitPage)) {
            $command[] = '-dFIXEDMEDIA';
            $command[] = '-dFitPage';
            $command[] = "-dDEVICEWIDTHPOINTS={$this->fitPage['width']}";
            $command[] = "-dDEVICEHEIGHTPOINTS={$this->fitPage['height']}";
        } else {
            $command[] = '-dEPSCrop';
        }

        if (!is_null($this->pageBox)) {
            $command[] = '-dUse' . $this->pageBox;
        }

        $command[] = '-dNOPLATFONTS';
        $command[] = '-dBATCH';
        $command[] = '-dNOPAUSE';
        $command[] = '-dSAFER';
        $command[] = '-sOutputFile=%stdout';
        $command[] = '-sstdout=%stderr';
        $command[] = '-q';
        $command[] = $file->getLocalPath();

        return $this->execute($command);
    }

    /**
     * Execute the specified command.
     *
     * @param array $command
     * @return string
     */
    protected function execute(array $command): string
    {
        $process = new Process($command);
        $process->setTimeout($this->timeout);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new GhostscriptException($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    /**
     * Get the corrected resolution.
     *
     * @return int
     */
    protected function getResolution(): int
    {
        if ($this->device instanceof DownScaling) {
            return $this->resolution * $this->device->getDownScaleFactor();
        }

        return $this->resolution;
    }
}
