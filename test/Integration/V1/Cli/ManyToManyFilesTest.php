<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Cli;

use Zarthus\Sass\Cli\V1\Argument\ManyToMany\SassMultipleFiles;
use Zarthus\Sass\Cli\V1\Argument\Output\SassFileOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class ManyToManyFilesTest extends IntegrationTestCase
{
    private const FILES = [
        'a.css',
        'b.css',
    ];

    public function testDirectoryCompile(): void
    {
        $input = $this->fixture('multiple-files/in/');
        $output = $this->fixture('multiple-files/out/');

        $result = $this->sass->getCli()->execute($this->sass->getCli()->createCommand(
            new SassArgumentCollection([
                new SassMultipleFiles(
                    [
                        $input . 'a.scss',
                        $input . 'b.scss',
                    ],
                    [
                        new SassFileOutput($output . 'a.css'),
                        new SassFileOutput($output . 'b.css'),
                    ]
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
        $output = $this->fixture('multiple-files/out/');
        foreach (self::FILES as $file) {
            unlink($output . $file);
            unlink($output . $file . '.map');
        }
        rmdir($output);
    }
}
