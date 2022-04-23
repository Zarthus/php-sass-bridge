<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Api;

use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Cli\V1\Options\SassStyle;
use Zarthus\Sass\SassFileType;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class SimpleSourceMapTest extends IntegrationTestCase
{
    public function testSassCompressed(): void
    {
        $input = $this->loadFixture('simple.sass');

        $result = $this->sass->getApi()->compileString(
            $input,
            SassFileType::Sass,
            (new SassCliOptions())->withoutSourceMap()->withStyle(SassStyle::Compressed)
        );

        $this->assertStringNotContainsString('soureceMappingURL', $result->getCss());
        $this->assertNull($result->getSourceMap());
    }

    public function testScss(): void
    {
        $input = $this->loadFixture('simple.scss');

        $result = $this->sass->getApi()->compileString(
            $input,
            SassFileType::Scss,
            (new SassCliOptions())->withoutSourceMap()
        );

        $this->assertStringNotContainsString('soureceMappingURL', $result->getCss());
        $this->assertNull($result->getSourceMap());
    }
}
