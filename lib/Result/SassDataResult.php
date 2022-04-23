<?php
declare(strict_types=1);

namespace Zarthus\Sass\Result;

/**
 * Prefer using memory over IO
 */
final class SassDataResult implements SassResultInterface
{
    public function __construct(
        private readonly string $css,
        private readonly ?string $sourceMap
    ) {
    }

    public function getCss(): string
    {
        return $this->css;
    }

    public function getSourceMap(): ?string
    {
        return $this->sourceMap;
    }

    public function toDataResult(bool $cleanup = false): SassDataResult
    {
        return $this;
    }
}
