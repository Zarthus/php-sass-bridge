<?php
declare(strict_types=1);

namespace Zarthus\Sass\TestFramework;

use PHPUnit\Framework\TestCase;
use Zarthus\Sass\Process\SassBinary;
use Zarthus\Sass\SassBuilder;

class UnitTestCase extends TestCase
{
    use LoadsFixtures;

    protected \Zarthus\Sass\Sass $sass;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sass = SassBuilder::fromBinaryPath(__DIR__ . '/../Mock/V1/sass-mock');
    }

    public function getBinary(): SassBinary
    {
        return new SassBinary([__DIR__ . '/../Mock/V1/sass-mock']);
    }
}
