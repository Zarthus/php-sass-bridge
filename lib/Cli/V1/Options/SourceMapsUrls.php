<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Options;

/**
 * https://sass-lang.com/documentation/cli/dart-sass#source-map-urls
 */
enum SourceMapsUrls: string
{
    case Relative = 'relative';
    case Absolute = 'absolute';
}
