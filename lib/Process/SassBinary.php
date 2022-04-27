<?php
declare(strict_types=1);

namespace Zarthus\Sass\Process;

use Zarthus\Sass\Exception\SassBinaryException;

final class SassBinary implements \Stringable
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private readonly string $sassBinary;

    /**
     * @param list<string> $paths
     *
     * @throws SassBinaryException
     */
    public function __construct(
        array $paths,
    ) {
        foreach ($paths as $path) {
            foreach ([$path, $path . '/sass', $path . '/sass.cmd'] as $try) {
                if (is_dir($try) || !file_exists($try)) {
                    continue;
                }

                $this->sassBinary = $try;
                return;
            }
        }

        throw new SassBinaryException('Cannot locate binary in provided paths: ' . var_export($paths, true));
    }
    public function getSassBinary(): string
    {
        return $this->sassBinary;
    }

    public function __toString(): string
    {
        return $this->sassBinary;
    }
}
