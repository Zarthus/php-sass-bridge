<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\ManyToMany;

use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentInterface;
use Zarthus\Sass\Cli\V1\Argument\SassMode;

/**
 * @since sass 1.4
 */
final class SassMultipleFilesToDir implements SassArgumentInterface
{
    /**
     * @param string[] $files
     */
    public function __construct(
        private readonly array $files,
        private readonly SassDirectoryOutput $output,
    ) {
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->files as $file) {
            $basename = str_replace(['.scss', '.sass'], '.css', basename($file));
            $array[] = "$file:$this->output/$basename";
        }
        return $array;
    }

    public function getMode(): SassMode
    {
        return SassMode::ManyToMany;
    }

    /**
     * Syntax: sass <input.scss>:<output> ...
     */
    public function __toString(): string
    {
        $string = '';
        foreach ($this->toArray() as $item) {
            $string .= $item . ' ';
        }
        return trim($string);
    }
}
