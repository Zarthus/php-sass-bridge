<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Executor;

use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Process\SassCommand;

interface SassExecutorInterface
{
    public function execute(SassCommand $command): string;

    public function createCommand(SassArgumentCollection $arguments, ?SassCliOptions $options = null): SassCommand;

    public function getHelp(): string;

    public function getVersion(): string;
}
