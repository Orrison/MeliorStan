<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class GlobalAndStatic
{
    public function withGlobal(): void
    {
        global $config;
    }

    public function withStatic(): int
    {
        static $counter = 0;
        $counter++;

        return $counter;
    }
}
