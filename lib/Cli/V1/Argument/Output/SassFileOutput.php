<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\Output;

final class SassFileOutput implements SassOutputInterface
{
    public function __construct(
        private readonly string $out,
    ) {
    }

    public function hasSourceMaps(): bool
    {
        return true;
    }

    public function __toString(): string
    {
        return $this->out;
    }
}
