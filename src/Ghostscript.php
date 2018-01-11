<?php

namespace RobGridley\Ghostscript;

use Symfony\Component\Process\Process;
use RobGridley\Ghostscript\Contracts\Device;
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
     * Convert the specified PDF to an image.
     *
     * @param string $pdf
     * @param int $page
     * @return string
     */
    public function convert(string $pdf, int $page = 1): string
    {
        $command[] = $this->path;
        $command[] = $this->device->getArguments();

        $command[] = sprintf('-dFirstPage=%d -dLastPage=%d', $page, $page);
        $command[] = sprintf('-dGraphicsAlphaBits=%d', $this->graphicsAntiAliasing);
        $command[] = sprintf('-dTextAlphaBits=%d', $this->textAntiAliasing);
        $command[] = sprintf('-r%d',$this->getResolution());

        if (!is_null($this->pageBox)) {
            $command[] = '-dUse' . $this->pageBox;
        }

        $command[] = '-dNOPLATFONTS -dBATCH -dNOPAUSE -dSAFER -sOutputFile=%stdout -q -';

        $command = implode(' ', $command);

        return $this->execute($command, $pdf);
    }

    /**
     * Execute the specified command.
     *
     * @param string $command
     * @param string $input
     * @return string
     */
    protected function execute(string $command, string $input): string
    {
        $process = new Process($command);

        $process->setInput($input);
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
