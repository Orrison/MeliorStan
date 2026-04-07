<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class ExceptionsFixture
{
    public function handle(int $used, int $unused, int $reported): int
    {
        return $used;
    }
}
