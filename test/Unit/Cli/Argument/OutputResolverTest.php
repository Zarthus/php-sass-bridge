<?php
declare(strict_types=1);

namespace Zarthus\Sass\UnitTest\Cli\Argument;

use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\Output\SassFileOutput;
use Zarthus\Sass\Cli\V1\Argument\Output\SassNoneOutput;
use Zarthus\Sass\Cli\V1\Argument\OutputResolver;
use Zarthus\Sass\TestFramework\UnitTestCase;

final class OutputResolverTest extends UnitTestCase
{
    public function testResolveNone(): void
    {
        $this->assertInstanceOf(SassNoneOutput::class, OutputResolver::resolve('foo/', null));
        $this->assertInstanceOf(SassNoneOutput::class, OutputResolver::resolve('foo.scss', null));
    }

    public function testResolveDirectory(): void
    {
        $this->assertInstanceOf(SassDirectoryOutput::class, OutputResolver::resolve('', 'foo/'));
        $this->assertInstanceOf(SassDirectoryOutput::class, OutputResolver::resolve('', $this->fixture('www')));
    }

    public function testResolveFile(): void
    {
        $this->assertInstanceOf(SassFileOutput::class, OutputResolver::resolve('', 'out.css'));
        $this->assertInstanceOf(SassFileOutput::class, OutputResolver::resolve('', 'out'));
    }
}
