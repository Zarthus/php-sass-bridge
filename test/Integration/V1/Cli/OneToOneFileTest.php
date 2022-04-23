<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Cli;

use Zarthus\Sass\Cli\V1\Argument\OneToOne\SassSingleFile;
use Zarthus\Sass\Cli\V1\Argument\Output\SassFileOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class OneToOneFileTest extends IntegrationTestCase
{
    private const FILES = [
        'a.css',
    ];

    public function testDirectoryCompile(): void
    {
        $input = $this->fixture('one-to-one/');
        $output = $this->fixture('one-to-one/');

        $result = $this->sass->getCli()->execute($this->sass->getCli()->createCommand(
            new SassArgumentCollection([
                new SassSingleFile(
                    $input . '/a.scss',
                    new SassFileOutput($output . '/a.css')
                ),
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
        $output = $this->fixture('one-to-one/');
        foreach (self::FILES as $file) {
            unlink($output . $file);
            unlink($output . $file . '.map');
        }
    }
}
