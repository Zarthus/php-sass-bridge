<?php
declare(strict_types=1);

namespace Zarthus\Sass\Api;

use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Exception\SassException;
use Zarthus\Sass\Result\SassResultInterface;
use Zarthus\Sass\SassFileType;

/**
 * https://sass-lang.com/documentation/js-api
 */
interface SassApi
{
    /**
     * @param string $string the sass to compile
     *
     * @throws SassException
     */
    public function compileString(string $string, ?SassFileType $fileType = null, ?SassCliOptions $options = null): SassResultInterface;

    /**
     * @param string $inputFile
     * @param string|null $outputFile if null, will output according to the sass binary (most likely same directory, different extension)
     *
     * @throws SassException
     */
    public function compile(string $inputFile, ?string $outputFile = null, ?SassCliOptions $options = null): SassResultInterface;
}
