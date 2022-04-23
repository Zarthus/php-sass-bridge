<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\ManyToMany;

use Zarthus\Sass\Cli\V1\Argument\Output\SassOutputInterface;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentInterface;
use Zarthus\Sass\Cli\V1\Argument\SassMode;

/**
 * @since sass 1.4
 */
final class SassDirectory implements SassArgumentInterface
{
    public function __construct(
        private readonly string $directory,
        private readonly SassOutputInterface $output,
    ) {
    }

    public function toArray(): array
    {
        return ["{$this->directory}:{$this->output}"];
    }

    public function getMode(): SassMode
    {
        return SassMode::ManyToMany;
    }

    /**
     * Syntax: sass <input>:<output>
     */
    public function __toString(): string
    {
        return "{$this->directory}:{$this->output}";
    }
}
