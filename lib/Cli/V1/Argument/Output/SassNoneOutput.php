<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\Output;

final class SassNoneOutput implements SassOutputInterface
{
    private readonly string $out;

    public function __construct(string $inFile)
    {
        $this->out = str_replace(['.scss', '.sass'], '.css', $inFile);
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
