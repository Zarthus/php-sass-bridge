<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Options;

/**
 * https://sass-lang.com/documentation/cli/dart-sass#style
 */
enum SassStyle: string
{
    case Expanded = 'expanded';
    case Compressed = 'compressed';
}
