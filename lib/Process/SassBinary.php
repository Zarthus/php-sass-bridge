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
            $try = $path;
            if (is_dir($path) && is_readable($path)) {
                $try .= '/sass';
            }

            if (!file_exists($try) || !is_executable($try)) {
                continue;
            }

            $this->sassBinary = $try;
            return;
        }

        throw new SassBinaryException('Cannot locate binary in provided paths');
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
