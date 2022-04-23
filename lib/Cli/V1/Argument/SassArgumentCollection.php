<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument;

use Zarthus\Sass\Cli\V1\Argument\ManyToMany\SassDirectory;
use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Exception\SassInvalidArgumentException;

final class SassArgumentCollection implements \Stringable
{
    private readonly SassMode $mode;

    /**
     * @param list<SassArgumentInterface> $arguments
     *
     * @throws SassInvalidArgumentException
     */
    public function __construct(
        private readonly array $arguments,
    ) {
        if ([] === $arguments) {
            $this->mode = SassMode::None;
        } else {
            $mode = current($this->arguments)->getMode();

            foreach ($arguments as $argument) {
                if ($mode !== $argument->getMode()) {
                    throw new SassInvalidArgumentException("Cannot mix modes {$mode->name} and {$argument->getMode()->name}");
                }
            }
            $this->mode = $mode;
        }
    }

    public static function directory(string $in, string $out): self
    {
        return new self([new SassDirectory($in, new SassDirectoryOutput($out))]);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function __toString(): string
    {
        $string = '';
        foreach ($this->arguments as $argument) {
            $string .= (string) $argument;
        }
        return $string;
    }

    public function getMode(): SassMode
    {
        return $this->mode;
    }
}
