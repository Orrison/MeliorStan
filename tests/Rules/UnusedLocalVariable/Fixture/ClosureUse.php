<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

use Closure;

class ClosureUse
{
    public function makeAdder(): Closure
    {
        $offset = 5;
        $stray = 10;

        return function (int $value) use ($offset): int {
            return $value + $offset;
        };
    }

    public function makeArrowAdder(): Closure
    {
        $offset = 5;

        return fn (int $value): int => $value + $offset;
    }
}
