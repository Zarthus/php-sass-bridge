<?php
declare(strict_types=1);

namespace Zarthus\Sass\UnitTest\Result;

use Monolog\Test\TestCase;
use Zarthus\Sass\Result\SassFileResult;

final class SassResultTest extends TestCase
{
    public function testResult(): void
    {
        $temp = sys_get_temp_dir() . '/' . bin2hex(random_bytes(12)) . 'dummy.css';
        file_put_contents($temp, 'test!');

        $result = new SassFileResult($temp, null);

        $this->assertSame('test!', $result->getCss());
        $this->assertNull($result->getSourceMap());

        $dataResult = $result->toDataResult(true);

        $this->assertSame('test!', $dataResult->getCss());
        $this->assertNull($dataResult->getSourceMap());
        $this->assertFileDoesNotExist($temp);
    }
}
