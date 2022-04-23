<?php
declare(strict_types=1);

namespace Zarthus\Sass\Api\V1;

use Zarthus\Sass\Api\SassApi;
use Zarthus\Sass\Cli\V1\Argument\OneToOne\SassSingleFile;
use Zarthus\Sass\Cli\V1\Argument\Output\SassFileOutput;
use Zarthus\Sass\Cli\V1\Argument\Output\SassNoneOutput;
use Zarthus\Sass\Cli\V1\Argument\SassArgumentCollection;
use Zarthus\Sass\Cli\V1\Options\SassCliOptions;
use Zarthus\Sass\Exception\SassException;
use Zarthus\Sass\Process\ProcessInterface;
use Zarthus\Sass\Result\SassFileResult;
use Zarthus\Sass\Result\SassResultInterface;
use Zarthus\Sass\SassFileType;

final class DefaultSassApi implements SassApi
{
    public function __construct(
        private readonly ProcessInterface $process,
    ) {
    }

    public function compileString(string $string, ?SassFileType $fileType = null, ?SassCliOptions $options = null): SassResultInterface
    {
        $fileType ??= str_contains($string, ';')
            ? SassFileType::Scss
            : SassFileType::Sass;

        $tmp = realpath(sys_get_temp_dir()) . '/zarthus-sass/';

        if (!is_dir($tmp) && !mkdir($tmp) && !is_dir($tmp)) {
            throw new SassException(sprintf('Directory "%s" was not created', $tmp));
        }

        $inFile = $tmp . 'zarthus_' . bin2hex(random_bytes(16)) . '.' . $fileType->value;
        $outFile = str_replace('.' . $fileType->value, '.css', $inFile);

        file_put_contents($inFile, $string);

        $options ??= new SassCliOptions();
        $options = match ($fileType) {
            SassFileType::Sass => $options,
            SassFileType::Scss => $options->withoutIndented(),
        };

        return $this->compile($inFile, $outFile, $options)->toDataResult(true);
    }

    public function compile(string $inputFile, ?string $outputFile = null, ?SassCliOptions $options = null): SassResultInterface
    {
        $options ??= (new SassCliOptions());

        $output = $outputFile === null ? new SassNoneOutput($inputFile) : new SassFileOutput($outputFile);
        $command = $this->process->createCommand(
            new SassArgumentCollection([
                new SassSingleFile($inputFile, $output)
            ]),
            $options,
        );

        $this->process->execute($command);

        return new SassFileResult((string) $output, ((string)$output) . '.map');
    }
}
