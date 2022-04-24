<?php
declare(strict_types=1);

namespace Zarthus\Sass\UnitTest;

use PHPUnit\Framework\TestCase;
use Zarthus\Sass\Api\V1\NullSassApi;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Executor\NullCliExecutor;
use Zarthus\Sass\Process\SassCommand;
use Zarthus\Sass\SassBuilder;

final class NullBuilderTest extends TestCase
{
    public function testNullBuilder(): void
    {
        $sass = SassBuilder::withNullHandlers();

        $this->assertInstanceOf(NullCliExecutor::class, $sass->getCli());
        $this->assertSame('', $sass->getCli()->execute(new SassCommand(SassArgumentCollection::empty())));

        $this->assertInstanceOf(NullSassApi::class, $sass->getApi());
        $compiled = $sass->getApi()->compileString('h1 { foo bar };');
        $this->assertSame('', $compiled->getCss());
        $this->assertNull($compiled->getSourceMap());
    }
}
