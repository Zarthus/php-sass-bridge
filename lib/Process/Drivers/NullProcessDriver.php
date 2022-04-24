<?php
declare(strict_types=1);

namespace Zarthus\Sass\Process\Drivers;

use Psr\Log\LoggerInterface;
use Zarthus\Sass\Process\AbstractProcessDriver;
use Zarthus\Sass\Process\SassBinary;
use Zarthus\Sass\Process\SassCommand;

final class NullProcessDriver extends AbstractProcessDriver
{
    public function __construct(?SassBinary $binary = null, ?LoggerInterface $logger = null)
    {
    }

    public function execute(SassCommand $command): string
    {
        return $this->doExecute($command);
    }

    protected function doExecute(SassCommand $command): string
    {
        return '';
    }
}
