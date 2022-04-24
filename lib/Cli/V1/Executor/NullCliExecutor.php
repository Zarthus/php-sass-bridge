<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Executor;

use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Process\ProcessInterface;
use Zarthus\Sass\Process\SassCommand;

final class NullCliExecutor implements SassExecutorInterface
{
    public function __construct(
        private readonly ?ProcessInterface $process = null,
    ) {
    }

    public function execute(SassCommand $command): string
    {
        return '';
    }

    public function createCommand(SassArgumentCollection $arguments, ?SassCliOptions $options = null): SassCommand
    {
        return new SassCommand(SassArgumentCollection::empty());
    }

    public function getHelp(): string
    {
        return '';
    }

    public function getVersion(): string
    {
        return '';
    }
}
