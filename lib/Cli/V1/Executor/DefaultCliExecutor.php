<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Executor;

use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Process\ProcessInterface;
use Zarthus\Sass\Process\SassCommand;

final class DefaultCliExecutor implements SassExecutorInterface
{
    public function __construct(
        private readonly ProcessInterface $process,
    ) {
    }

    public function execute(SassCommand $command): string
    {
        return $this->process->execute($command);
    }

    public function createCommand(SassArgumentCollection $arguments, ?SassCliOptions $options = null): SassCommand
    {
        return $this->process->createCommand($arguments, $options);
    }

    public function getHelp(): string
    {
        return $this->process->execute($this->process->createCommand(
            SassArgumentCollection::empty(), (new SassCliOptions())->with('--help')
        ));
    }

    public function getVersion(): string
    {
        return $this->process->execute($this->process->createCommand(
            SassArgumentCollection::empty(), (new SassCliOptions())->with('--version')
        ));
    }
}
