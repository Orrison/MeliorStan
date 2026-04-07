<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

use Closure;

class ArrowFunctionUses
{
    public function wrap(int $outer): Closure
    {
        return fn () => $outer + 1;
    }
}
