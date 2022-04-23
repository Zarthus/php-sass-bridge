<?php
declare(strict_types=1);

namespace Zarthus\Sass;

use Zarthus\Sass\Api\SassApi;
use Zarthus\Sass\Api\V1\DefaultSassApi;
use Zarthus\Sass\Cli\V1\Executor\DefaultCliExecutor;
use Zarthus\Sass\Cli\V1\Executor\SassExecutorInterface;
use Zarthus\Sass\Exception\SassException;
use Zarthus\Sass\Process\Drivers\ShellExecProcessDriver;
use Zarthus\Sass\Process\Drivers\SymfonyProcessDriver;
use Zarthus\Sass\Process\ProcessInterface;
use Zarthus\Sass\Process\SassBinary;

final class SassBuilder
{
    private ?SassExecutorInterface $cli = null;
    private ?ProcessInterface $process = null;
    private ?SassApi $api = null;

    public function __construct(
        private readonly SassBinary $binary,
    ) {
    }

    public static function fromBinaryPath(string $binaryPath): Sass
    {
        $bin = new SassBinary([$binaryPath]);

        return (new self($bin))->build();
    }

    /**
     * @param list<string> $binaryPaths
     *
     * @throws SassException
     */
    public static function autodetect(?array $binaryPaths = null): Sass
    {
        if ($binaryPaths === null) {
            $path = getenv('PATH');
            if (false === $path) {
                throw new SassException('Cannot autodetect, PATH env is not set');
            }

            $binaryPaths = explode(':', trim($path));
        }
        $bin = new SassBinary($binaryPaths);

        return (new self($bin))->build();
    }

    public function withProcess(ProcessInterface $process): self
    {
        $this->process = $process;
        return $this;
    }

    public function withCli(SassExecutorInterface $executor): self
    {
        $this->cli = $executor;
        return $this;
    }

    public function withApi(SassApi $api): self
    {
        $this->api = $api;
        return $this;
    }

    public function build(): Sass
    {
        if (null === $this->process) {
            if (class_exists(\Symfony\Component\Process\Process::class, true)) {
                $this->process = new SymfonyProcessDriver($this->binary);
            } else {
                $this->process = new ShellExecProcessDriver($this->binary);
            }
        }

        if (null === $this->api) {
            $this->api = new DefaultSassApi($this->process);
        }
        if (null === $this->cli) {
            $this->cli = new DefaultCliExecutor($this->process);
        }

        return new Sass($this->cli, $this->api);
    }
}
