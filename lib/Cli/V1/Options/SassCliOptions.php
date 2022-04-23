<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Options;

final class SassCliOptions implements \Stringable
{
    /**
     * @param string[] $args
     */
    public function __construct(
        private array $args = [],
    ) {
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#indented
     */
    public function withoutIndented(): self
    {
        $this->args[] = '--no-indented';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#load-path
     */
    public function withLoadPath(string $path): self
    {
        $this->args[] = '--load-path=' . $path;
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#style
     */
    public function withStyle(SassStyle $style): self
    {
        $this->args[] = '--style=' . $style->value;
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#no-charset
     */
    public function withoutCharset(): self
    {
        $this->args[] = '--no-charset';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#error-css
     */
    public function withErrorCss(): self
    {
        $this->args[] = '--error-css';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#update
     */
    public function withUpdate(): self
    {
        $this->args[] = '--update';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#no-source-map
     */
    public function withoutSourceMap(): self
    {
        $this->args[] = '--no-source-map';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#source-map-urls
     */
    public function withSourceMapUrls(SourceMapsUrls $mapsUrls): self
    {
        $this->args[] = '--source-map-urls=' . $mapsUrls->value;
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#embed-sources
     */
    public function withEmbedSources(): self
    {
        $this->args[] = '--embed-sources';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#embed-source-map
     */
    public function withEmbedSourceMap(): self
    {
        $this->args[] = '--embed-source-map';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#stop-on-error
     */
    public function withStopOnError(): self
    {
        $this->args[] = '--stop-on-error';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#color
     */
    public function withColor(): self
    {
        $this->args[] = '--color';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#no-unicode
     */
    public function withoutUnicode(): self
    {
        $this->args[] = '--no-unicode';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#quiet
     */
    public function withQuiet(): self
    {
        $this->args[] = '--quiet';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#quiet-deps
     */
    public function withQuietDependencies(): self
    {
        $this->args[] = '--quiet-deps';
        return $this;
    }

    /**
     * @link https://sass-lang.com/documentation/cli/dart-sass#trace
     */
    public function withTrace(): self
    {
        $this->args[] = '--trace';
        return $this;
    }

    /**
     * This method is not officially supported and may lead to undefined behaviour, but is provided for flexibility.
     * @link https://sass-lang.com/documentation/cli/dart-sass
     */
    public function with(string $argument): self
    {
        $this->args[] = $argument;
        return $this;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function __toString(): string
    {
        return implode(' ', $this->args);
    }
}
