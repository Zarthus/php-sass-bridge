<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Cli;

use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class DirectoryCompileTest extends IntegrationTestCase
{
    private const FILES = [
        'foo.css',
        'bar.css',
    ];

    public function testDirectoryCompile(): void
    {
        $input = $this->fixture('www/sass/');
        $output = $this->fixture('www/css/');

        $result = $this->sass->getCli()->execute($this->sass->getCli()->createCommand(
            SassArgumentCollection::directory($input, $output),
            new SassCliOptions(),
        ));

        $this->assertEmpty($result);

        foreach (self::FILES as $file) {
            $this->assertFileExists($output . $file);
            $this->assertFileExists($output . $file . '.map');
        }
    }

    protected function tearDown(): void
    {
        $output = $this->fixture('www/css/');
        foreach (self::FILES as $file) {
            unlink($output . $file);
            unlink($output . $file . '.map');
        }
    }
}
