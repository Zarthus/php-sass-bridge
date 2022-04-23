<?php
declare(strict_types=1);

namespace Zarthus\Sass\Process;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Exception\SassCommandExecutionException;
use Zarthus\Sass\Exception\SassException;

abstract class AbstractProcessDriver implements ProcessInterface
{
    private readonly LoggerInterface $logger;

    public function __construct(
        private readonly SassBinary $binary,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function execute(SassCommand $command): string
    {
        if ($command->getBinary() === null) {
            $command->setBinary($this->binary);
        }

        $this->logger->debug("Executing command: $command");
        try {
            $result = $this->doExecute($command);
        } catch (SassCommandExecutionException $e) {
            $this->logger->error("Command \"$command\" failed to execute.");
            throw $e;
        } catch (SassException $e) {
            $this->logger->error("Command \"$command\" failed to execute.");
            throw new SassCommandExecutionException("Command \"$command\" failed to execute.", 0, $e);
        }

        $this->logger->debug("Command Output: " . $result);
        $this->logger->info("Completed command: {$command->getArguments()} {$command->getOptions()}");
        return trim($result);
    }

    /**
     * @throws SassException
     */
    abstract protected function doExecute(SassCommand $command): string;

    public function createCommand(SassArgumentCollection $arguments, ?SassCliOptions $options): SassCommand
    {
        return new SassCommand($arguments, $options, $this->binary);
    }

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    protected function getBinary(): SassBinary
    {
        return $this->binary;
    }
}
