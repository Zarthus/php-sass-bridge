<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Cli;

use Zarthus\Sass\Cli\V1\Argument\ManyToMany\SassMultipleFilesToDir;
use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class ManyToManyFilesToDirectoryTest extends IntegrationTestCase
{
    private const FILES = [
        'a.css',
        'b.css',
    ];

    public function testDirectoryCompile(): void
    {
        $input = $this->fixture('multiple-dirs/in/');
        $output = $this->fixture('multiple-dirs/out/');

        $result = $this->sass->getCli()->execute($this->sass->getCli()->createCommand(
            new SassArgumentCollection([
                new SassMultipleFilesToDir(
                    [
                        $input . 'a.scss',
                        $input . 'b.scss',
                    ],
                    new SassDirectoryOutput($output),
                )
            ]),
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
        $output = $this->fixture('multiple-dirs/out/');
        foreach (self::FILES as $file) {
            unlink($output . $file);
            unlink($output . $file . '.map');
        }
        rmdir($output);
    }
}
