<?php
declare(strict_types=1);

namespace Zarthus\Sass\Result;

interface SassResultInterface
{
    public function getCss(): string;
    public function getSourceMap(): ?string;

    public function toDataResult(bool $cleanup = false): SassDataResult;
}
