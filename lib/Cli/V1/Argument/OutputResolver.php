<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument;

use Zarthus\Sass\Cli\V1\Argument\Output\SassDirectoryOutput;
use Zarthus\Sass\Cli\V1\Argument\Output\SassFileOutput;
use Zarthus\Sass\Cli\V1\Argument\Output\SassNoneOutput;
use Zarthus\Sass\Cli\V1\Argument\Output\SassOutputInterface;

final class OutputResolver
{
    public static function resolve(string $in, ?string $out): SassOutputInterface
    {
        if (null === $out) {
            return new SassNoneOutput($in);
        }
        if (str_ends_with($out, '/') || is_dir($out)) {
            return new SassDirectoryOutput($out);
        }
        return new SassFileOutput($out);
    }
}
