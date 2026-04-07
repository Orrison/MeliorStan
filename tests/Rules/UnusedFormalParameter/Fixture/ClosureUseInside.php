<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

use Closure;

class ClosureUseInside
{
    public function wrap(int $outer): Closure
    {
        return function () use ($outer) {
            return $outer + 1;
        };
    }
}
