<?php
declare(strict_types=1);

namespace Zarthus\Sass\Process;

use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Exception\SassCommandExecutionException;

interface ProcessInterface
{
    /**
     * @throws SassCommandExecutionException
     */
    public function execute(SassCommand $command): string;

    public function createCommand(
        SassArgumentCollection $arguments,
        ?SassCliOptions $options,
    ): SassCommand;
}
