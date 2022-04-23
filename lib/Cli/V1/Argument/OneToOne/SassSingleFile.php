<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\OneToOne;

use Zarthus\Sass\Cli\V1\Argument\Output\SassOutputInterface;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentInterface;
use Zarthus\Sass\Cli\V1\Argument\SassMode;

final class SassSingleFile implements SassArgumentInterface
{
    public function __construct(
        private readonly string $file,
        private readonly ?SassOutputInterface $output,
    ) {
    }

    public function toArray(): array
    {
        $array = [$this->file];
        if ($this->output) {
            $array[] = (string) $this->output;
        }
        return $array;
    }

    public function getMode(): SassMode
    {
        return SassMode::OneToOne;
    }

    /**
     * Syntax:
     * sass <input.scss> [output.css]
     */
    public function __toString(): string
    {
        return implode(' ', $this->toArray());
    }
}
