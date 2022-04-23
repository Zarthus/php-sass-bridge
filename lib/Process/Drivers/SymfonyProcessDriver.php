<?php
declare(strict_types=1);

namespace Zarthus\Sass\Process\Drivers;

use Symfony\Component\Process\Process;
use Zarthus\Sass\Exception\SassCommandExecutionException;
use Zarthus\Sass\Process\AbstractProcessDriver;
use Zarthus\Sass\Process\SassCommand;

final class SymfonyProcessDriver extends AbstractProcessDriver
{
    protected function doExecute(SassCommand $command): string
    {
        $process = new Process($command->toArray());
        $exitCode = $process->run();

        if ($exitCode !== 0) {
            throw new SassCommandExecutionException(
                "Exit code was non-zero ({$process->getExitCode()}) - {$process->getErrorOutput()} | {$process->getExitCodeText()}"
            );
        }

        return $process->getOutput();
    }
}
