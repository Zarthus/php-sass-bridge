<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\Output;

final class SassDirectoryOutput implements SassOutputInterface
{
    public function __construct(
        private readonly string $dir,
    ) {
    }

    public function hasSourceMaps(): bool
    {
        return false;
    }

    public function __toString(): string
    {
        return $this->dir;
    }
}
