<?php
declare(strict_types=1);

namespace Zarthus\Sass\UnitTest\Cli;

use Zarthus\Sass\TestFramework\UnitTestCase;

final class HelpCommandTest extends UnitTestCase
{
    public function testHelp(): void
    {
        $help = $this->sass->getCli()->getHelp();

        $this->assertStringContainsString('Usage: sass <input.scss> [output.css]', $help);
    }
}
