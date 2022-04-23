<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest\V1\Api;

use Zarthus\Sass\SassFileType;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class SimpleCompilationTest extends IntegrationTestCase
{
    public function testSass(): void
    {
        $input = $this->loadFixture('simple.sass');
        $output = $this->loadFixture('simple.css');

        $result = $this->sass->getApi()->compileString($input, SassFileType::Sass);

        $this->assertStringStartsWith($output, $result->getCss());
        $this->assertNotNull($result->getSourceMap());
    }

    public function testScss(): void
    {
        $input = $this->loadFixture('simple.scss');
        $output = $this->loadFixture('simple.css');

        $result = $this->sass->getApi()->compileString($input, SassFileType::Scss);

        $this->assertStringStartsWith($output, $result->getCss());
        $this->assertNotNull($result->getSourceMap());
    }

    public function testAutodetect(): void
    {
        $inputSass = $this->loadFixture('simple.sass');
        $inputScss = $this->loadFixture('simple.scss');
        $output = $this->loadFixture('simple.css');

        $resultSass = $this->sass->getApi()->compileString($inputSass, null);
        $resultScss = $this->sass->getApi()->compileString($inputScss, null);

        $this->assertStringStartsWith($output, $resultSass->getCss(), 'sass autodetect failed');
        $this->assertNotNull($resultSass->getSourceMap());

        $this->assertStringStartsWith($output, $resultScss->getCss(), 'scss autodetect failed');
        $this->assertNotNull($resultScss->getSourceMap());
    }
}
