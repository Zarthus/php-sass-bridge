<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest;

use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class ProvidedBinaryTest extends IntegrationTestCase
{
    private const FILE_PATH = __DIR__ . '/../../bin/zarthus-sass';

    public function testBinary(): void
    {
        $this->assertFileExists(self::FILE_PATH);

        putenv('ZARTHUS_SASS_BINARY=' . $this->fixture('dummybin'));

        exec(self::FILE_PATH . ' ' .  $this->fixture('test.sass'), $output, $code);
        $this->assertSame(0, $code);

        exec(
            self::FILE_PATH . ' ' .  $this->fixture('test.sass') . ' ' . $this->fixture('test.sass') . ' --version --arg1 --arg2 --arg3',
            $output,
            $code
        );
        $this->assertSame(0, $code);
    }
}
