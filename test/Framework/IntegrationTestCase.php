<?php
declare(strict_types=1);

namespace Zarthus\Sass\TestFramework;

use PHPUnit\Framework\TestCase;
use Zarthus\Sass\SassBuilder;

class IntegrationTestCase extends TestCase
{
    use LoadsFixtures;

    protected \Zarthus\Sass\Sass $sass;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sass = file_exists('/usr/bin/sass')
            ? SassBuilder::fromBinaryPath('/usr/bin/sass')
            : SassBuilder::autodetect();
    }
}
