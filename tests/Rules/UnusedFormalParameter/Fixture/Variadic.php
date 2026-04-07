<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class Variadic
{
    public function usedVariadic(int ...$values): int
    {
        return array_sum($values);
    }

    public function unusedVariadic(int ...$values): int
    {
        return 0;
    }
}
