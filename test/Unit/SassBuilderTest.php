<?php
declare(strict_types=1);

namespace Zarthus\Sass\UnitTest;

use PHPUnit\Framework\MockObject\MockObject;
use Zarthus\Sass\Api\SassApi;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Executor\SassExecutorInterface;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Process\ProcessInterface;
use Zarthus\Sass\Process\SassCommand;
use Zarthus\Sass\Result\SassDataResult;
use Zarthus\Sass\Sass;
use Zarthus\Sass\SassBuilder;
use Zarthus\Sass\TestFramework\UnitTestCase;

final class SassBuilderTest extends UnitTestCase
{
    private SassApi|MockObject $api;
    private SassExecutorInterface|MockObject $cli;

    protected function setUp(): void
    {
        parent::setUp();

        $this->api = $this->createMock(SassApi::class);
        $this->cli = $this->createMock(SassExecutorInterface::class);
    }


    public function testApi(): void
    {
        $sass = $this->createSass();
        $this->api
            ->expects($this->once())
            ->method('compileString')
            ->willReturn(new SassDataResult('foo', null));

        $result = $sass->getApi()->compileString('foo');
        $this->assertSame('foo', $result->getCss());
    }

    public function testCli(): void
    {
        $sass = $this->createSass();
        $this->cli
            ->expects($this->once())
            ->method('execute')
            ->willReturn('foo');

        $result = $sass->getCli()->execute(
            new SassCommand(SassArgumentCollection::empty(), new SassCliOptions(), $this->getBinary())
        );

        $this->assertSame('foo', $result);
    }

    private function createSass(): Sass
    {
        return (new SassBuilder($this->getBinary()))
            ->withProcess($this->createMock(ProcessInterface::class))
            ->withApi($this->api)
            ->withCli($this->cli)
            ->build();
    }
}
