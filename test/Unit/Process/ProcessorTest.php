<?php
declare(strict_types=1);

namespace Zarthus\Sass\UnitTest\Process;

use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Process\Drivers\ShellExecProcessDriver;
use Zarthus\Sass\Process\Drivers\SymfonyProcessDriver;
use Zarthus\Sass\Process\SassBinary;
use Zarthus\Sass\Process\SassCommand;
use Zarthus\Sass\TestFramework\UnitTestCase;

final class ProcessorTest extends UnitTestCase
{
    public function testShellProcessor(): void
    {
        $processor = new ShellExecProcessDriver($this->dummyBinary());
        $result = $processor->execute(new SassCommand(SassArgumentCollection::empty()));

        $this->assertSame('TEST SUCCESS', $result);
    }

    public function testSymfonyProcessor(): void
    {
        if (!class_exists(\Symfony\Component\Process\Process::class)) {
            $this->markTestSkipped('Required: symfony/process');
        }

        $processor = new SymfonyProcessDriver($this->dummyBinary());
        $result = $processor->execute(new SassCommand(SassArgumentCollection::empty()));

        $this->assertSame('TEST SUCCESS', $result);
    }

    private function dummyBinary(): SassBinary
    {
        $dummy = $this->fixture('dummybin');
        return new SassBinary([$dummy]);
    }
}
