<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument\Output;

interface SassOutputInterface extends \Stringable
{
    public function hasSourceMaps(): bool;
}
