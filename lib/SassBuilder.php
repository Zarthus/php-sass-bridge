<?php
declare(strict_types=1);

namespace Zarthus\Sass;

use Psr\Log\LoggerInterface;
use Zarthus\Sass\Api\SassApi;
use Zarthus\Sass\Api\V1\DefaultSassApi;
use Zarthus\Sass\Api\V1\NullSassApi;
use Zarthus\Sass\Cli\V1\Executor\DefaultCliExecutor;
use Zarthus\Sass\Cli\V1\Executor\NullCliExecutor;
use Zarthus\Sass\Cli\V1\Executor\SassExecutorInterface;
use Zarthus\Sass\Exception\SassBinaryException;
use Zarthus\Sass\Exception\SassException;
use Zarthus\Sass\Process\Drivers\NullProcessDriver;
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
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    public static function fromBinaryPath(string $binaryPath, ?LoggerInterface $logger = null): Sass
    {
        $bin = new SassBinary([$binaryPath]);

        return (new self($bin, $logger))->build();
    }

    /**
     * @param list<string> $binaryPaths
     *
     * @throws SassException
     */
    public static function autodetect(?array $binaryPaths = null, ?LoggerInterface $logger = null): Sass
    {
        if ($binaryPaths === null) {
            $path = getenv('PATH');
            if (false === $path) {
                throw new SassException('Cannot autodetect, PATH env is not set');
            }

            /** @var list<string> $binaryPaths */
            $binaryPaths = array_filter(explode(PHP_OS_FAMILY === 'Windows' ? ';' : ':', trim($path)));
        }
        $bin = new SassBinary($binaryPaths);

        return (new self($bin, $logger))->build();
    }

    // Populates the builder with the Null API, CLI Executor, and ProcessDriver
    public static function withNullHandlers(?SassBinary $binary = null): Sass
    {
        if (null === $binary) {
            $reflection = new \ReflectionClass(SassBinary::class);
            try {
                $binary = $reflection->newInstanceWithoutConstructor();
            } catch (\ReflectionException $e) {
                throw new SassBinaryException('Cannot mock binary', 0, $e);
            }
        }

        return (new self($binary))
            ->withProcess($process = new NullProcessDriver())
            ->withApi(new NullSassApi($process))
            ->withCli(new NullCliExecutor($process))
            ->build();
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
                $this->process = new SymfonyProcessDriver($this->binary, $this->logger);
            } else {
                $this->process = new ShellExecProcessDriver($this->binary, $this->logger);
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
