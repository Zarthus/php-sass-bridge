<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest;

use Zarthus\Sass\SassBuilder;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class AutoresolverTest extends IntegrationTestCase
{
    public function testAutoresolve(): void
    {
        SassBuilder::autodetect();

        $this->assertTrue(true);
    }
}
