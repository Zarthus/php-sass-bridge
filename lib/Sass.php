<?php
declare(strict_types=1);

namespace Zarthus\Sass;

use Zarthus\Sass\Api\SassApi;
use Zarthus\Sass\Cli\V1\Executor\SassExecutorInterface;

/**
 * @see SassBuilder on how to construct this class easily
 */
final class Sass
{
    public function __construct(
        private readonly SassExecutorInterface $executor,
        private readonly SassApi $api,
    ) {
    }

    /**
     * Allows you to execute nearly all sass commands to the sass binary
     */
    public function getCli(): SassExecutorInterface
    {
        return $this->executor;
    }

    /**
     * Gets the "API" (which is just a wrapper of the CLI under the hood) to allow you to compile sass 'programmatically',
     */
    public function getApi(): SassApi
    {
        return $this->api;
    }
}
