<?php
declare(strict_types=1);

namespace Zarthus\Sass\Api\V1;

use Zarthus\Sass\Api\SassApi;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Process\ProcessInterface;
use Zarthus\Sass\Result\SassDataResult;
use Zarthus\Sass\Result\SassResultInterface;
use Zarthus\Sass\SassFileType;

final class NullSassApi implements SassApi
{
    public function __construct(
        private readonly ?ProcessInterface $process = null,
    ) {
    }

    public function compileString(string $string, ?SassFileType $fileType = null, ?SassCliOptions $options = null): SassResultInterface
    {
        return $this->compile('', '', $options);
    }

    public function compile(string $inputFile, ?string $outputFile = null, ?SassCliOptions $options = null): SassResultInterface
    {
        return new SassDataResult('', null);
    }
}
