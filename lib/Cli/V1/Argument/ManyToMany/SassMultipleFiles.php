<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\ManyToMany;

use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\Output\SassFileOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentInterface;
use Zarthus\Sass\Cli\V1\Argument\SassMode;
use Zarthus\Sass\Exception\SassInvalidArgumentException;

/**
 * @since sass 1.4
 */
final class SassMultipleFiles implements SassArgumentInterface
{
    /** @var string[] */
    private array $files;
    /** @var SassFileOutput[] */
    private array $outputs;

    /**
     * @param string[] $files
     * @param SassFileOutput[] $outputs
     */
    public function __construct(
        array $files,
        array $outputs,
    ) {
        if ([] === $files) {
            throw new SassInvalidArgumentException('Files must be a non-empty list');
        }
        if ([] === $outputs) {
            throw new SassInvalidArgumentException('Outputs must be a non-empty list');
        }

        $this->files = array_values($files);
        $this->outputs = array_values($outputs);

        if (count($this->files) !== count($this->outputs)) {
            throw new SassInvalidArgumentException('Argument count for files & outputs does not match');
        }
    }

    public function toArray(): array
    {
        /**
         * @var array<string, SassDirectoryOutput> $combine
         */
        $combine = array_combine($this->files, $this->outputs);

        $array = [];
        foreach ($combine as $file => $output) {
            $array[] = "{$file}:{$output}";
        }
        return $array;
    }

    public function getMode(): SassMode
    {
        return SassMode::ManyToMany;
    }

    /**
     * Syntax: sass <input.scss>:<output.css> ...
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
