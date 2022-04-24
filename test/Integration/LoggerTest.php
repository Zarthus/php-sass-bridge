<?php
declare(strict_types=1);

namespace Zarthus\Sass\IntTest;

use Monolog\Handler\Handler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Zarthus\Sass\SassBuilder;
use Zarthus\Sass\TestFramework\IntegrationTestCase;

final class LoggerTest extends IntegrationTestCase
{
    public function testBinary(): void
    {
        $logs = [];
        $logger = new Logger('IntTest');
        $logger->pushHandler($handler = new class extends Handler {
            public function __construct(private array $records = [])
            {
            }

            public function isHandling(array $record): bool
            {
                return true;
            }

            public function handle(array $record): bool
            {
                if (str_contains($record['message'], 'Completed command')) {
                    $this->records[] = $record['message'];
                }
                return true;
            }

            public function getRecords(): array
            {
                return $this->records;
            }
        });

        SassBuilder::autodetect(null, $logger)->getCli()->getVersion();
        $records = $handler->getRecords();

        $this->assertNotEmpty($records);
        $this->assertCount(1, $records);
        $this->assertSame('Completed command:  --version', current($records));
    }
}
