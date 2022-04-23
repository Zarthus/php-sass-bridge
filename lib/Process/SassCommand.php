<?php
declare(strict_types=1);

namespace Zarthus\Sass\Process;

use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;

final class SassCommand implements \Stringable
{
    private readonly SassCliOptions $options;

    public function __construct(
        private readonly SassArgumentCollection $arguments,
        ?SassCliOptions $options = null,
        private ?SassBinary $binary = null,
    ) {
        $this->options = $options ?? new SassCliOptions();
    }

    public function getArguments(): SassArgumentCollection
    {
        return $this->arguments;
    }

    public function getOptions(): SassCliOptions
    {
        return $this->options;
    }

    public function setBinary(SassBinary $binary): void
    {
        $this->binary = $binary;
    }

    public function getBinary(): ?SassBinary
    {
        return $this->binary;
    }

    /**
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress MixedAssignment
     */
    public function toArray(): array
    {
        $command = [
            (string) $this->binary,
        ];
        foreach ($this->arguments->getArguments() as $argument) {
            foreach ($argument->toArray() as $arg) {
                $command[] = (string) $arg;
            }
        }
        foreach ($this->options->getArgs() as $option) {
            $command[] = (string) $option;
        }
        return $command;
    }

    public function __toString(): string
    {
        return "{$this->binary} {$this->options} {$this->arguments}";
    }
}
