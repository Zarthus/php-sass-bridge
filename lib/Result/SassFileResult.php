<?php
declare(strict_types=1);

namespace Zarthus\Sass\Result;

/**
 * Prefer using IO over memory
 */
final class SassFileResult implements SassResultInterface
{
    public function __construct(
        private readonly string $file,
        private readonly ?string $sourceMap
    ) {
    }

    public function getCss(): string
    {
        return file_get_contents($this->file);
    }

    public function getSourceMap(): ?string
    {
        if ($this->sourceMap === null) {
            return null;
        }
        if (!file_exists($this->sourceMap)) {
            return null;
        }
        return file_get_contents($this->sourceMap);
    }

    public function toDataResult(bool $cleanup = false): SassDataResult
    {
        $result = new SassDataResult(
            $this->getCss(),
            $this->getSourceMap()
        );
        if ($cleanup) {
            unlink($this->file);
            if ($this->sourceMap && file_exists($this->sourceMap)) {
                unlink($this->sourceMap);
            }
        }
        return $result;
    }
}
