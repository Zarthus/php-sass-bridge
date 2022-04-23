<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\ManyToMany;

use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentInterface;
use Zarthus\Sass\Cli\V1\Argument\SassMode;
use Zarthus\Sass\Exception\SassInvalidArgumentException;

/**
 * @since sass 1.4
 */
final class SassMultipleDirectories implements SassArgumentInterface
{
    /** @var string[] */
    private array $directories;
    /** @var SassDirectoryOutput[] */
    private array $outputs;

    /**
     * @param non-empty-list<string> $directories
     * @param list<SassDirectoryOutput> $outputs
     *
     * @psalm-suppress TypeDoesNotContainType
     * @psalm-suppress RedundantFunctionCall
     *
     * @throws SassInvalidArgumentException
     */
    public function __construct(
        array $directories,
        array $outputs,
    ) {
        if ([] === $directories) {
            throw new SassInvalidArgumentException('Directories must be a non-empty list');
        }
        if ([] === $outputs) {
            throw new SassInvalidArgumentException('Outputs must be a non-empty list');
        }

        $this->directories = array_values($directories);
        $this->outputs = array_values($outputs);

        if (count($this->directories) !== count($this->outputs)) {
            throw new SassInvalidArgumentException('Argument count for directories & outputs does not match');
        }
    }

    public function toArray(): array
    {
        /**
         * @var array<string, SassDirectoryOutput> $combine
         */
        $combine = array_combine($this->directories, $this->outputs);

        $array = [];
        foreach ($combine as $dir => $output) {
            $array[] = "{$dir}:{$output}";
        }
        return $array;
    }

    public function getMode(): SassMode
    {
        return SassMode::ManyToMany;
    }

    /**
     * Syntax: sass <input>:<output> ...
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
