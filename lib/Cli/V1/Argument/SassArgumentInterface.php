<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument;

/**
 * Marker interface that cannot be implemented by non-library-users
 *
 * @internal
 */
interface SassArgumentInterface extends \Stringable
{
    /** @return string[] */
    public function toArray(): array;

    public function getMode(): SassMode;
}
