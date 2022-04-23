<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Cli;

use Zarthus\Sass\Cli\V1\Argument\ManyToMany\SassMultipleDirectories;
use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class ManyToManyDirectoryTest extends IntegrationTestCase
{
    private const FILES = [
        'a/a.css',
        'b/b.css',
    ];

    public function testDirectoryCompile(): void
    {
        $input = $this->fixture('many-to-many/in/');
        $output = $this->fixture('many-to-many/out/');

        $result = $this->sass->getCli()->execute($this->sass->getCli()->createCommand(
            new SassArgumentCollection([
                new SassMultipleDirectories(
                    [
                        $input . 'a/',
                        $input . 'b/'
                    ],
                    [
                        new SassDirectoryOutput($output . 'a/'),
                        new SassDirectoryOutput($output . 'b/')
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
        $output = $this->fixture('many-to-many/out/');
        foreach (self::FILES as $file) {
            unlink($output . $file);
            unlink($output . $file . '.map');
            rmdir($output . dirname($file));
        }
        rmdir($output);
    }
}
