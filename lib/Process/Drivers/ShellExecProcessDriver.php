<?php
declare(strict_types=1);

namespace Zarthus\Sass\Process\Drivers;

use Zarthus\Sass\Exception\SassCommandExecutionException;
use Zarthus\Sass\Process\AbstractProcessDriver;
use Zarthus\Sass\Process\SassCommand;

final class ShellExecProcessDriver extends AbstractProcessDriver
{
    /**
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    protected function doExecute(SassCommand $command): string
    {
        /**
         * @var string[] $result
         * @var int $resultCode
         */
        exec((string) $command, $result, $resultCode);

        if ($resultCode !== 0) {
            $cmdResult = substr(implode(' ', $result), 0, 64);
            throw new SassCommandExecutionException("Exit code was non-zero ($resultCode) - $cmdResult");
        }

        return implode("\n", $result);
    }
}
