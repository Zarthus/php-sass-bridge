<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Cli;

use Zarthus\Sass\Cli\V1\Argument\ManyToMany\SassDirectory;
use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class ComplexScssTest extends IntegrationTestCase
{
    public function testDirectoryCompile(): void
    {
        $input = $this->fixture('complex/in/');
        $output = $this->fixture('complex/out/');

        $result = $this->sass->getCli()->execute($this->sass->getCli()->createCommand(
            new SassArgumentCollection([
                new SassDirectory($input, new SassDirectoryOutput($output)),
            ]),
            new SassCliOptions(),
        ));

        $this->assertEmpty($result);
        $this->assertFileExists($output . 'foo.css');
        $this->assertTrue(str_contains(file_get_contents($output . 'foo.css'), 'background-color'));
        $this->assertDirectoryDoesNotExist($output . 'layouts');
        $this->assertDirectoryDoesNotExist($output . 'mixins');
    }

    protected function tearDown(): void
    {
        $output = $this->fixture('complex/out/');

        unlink($output . 'foo.css');
        unlink($output . 'foo.css.map');
    }
}
