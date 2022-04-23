<?php
declare(strict_types=1);

namespace Zarthus\Sass\TestFramework;

trait LoadsFixtures
{
    protected function fixture(string $fixture): string
    {
        return __DIR__ . '/../Fixtures/' . $fixture;
    }

    protected function loadFixture(string $fixture): string
    {
        return file_get_contents($this->fixture($fixture));
    }
}
