<?php
declare(strict_types=1);

namespace Zarthus\Sass\UnitTest\Cli;

use Zarthus\Sass\TestFramework\UnitTestCase;

final class VersionCommandTest extends UnitTestCase
{
    public function testVersion(): void
    {
        $version = $this->sass->getCli()->getVersion();

        $this->assertSame('sass 1.5.0', $version);
    }
}
