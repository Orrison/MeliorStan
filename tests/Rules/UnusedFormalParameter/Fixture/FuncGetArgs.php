<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class FuncGetArgs
{
    public function variadicLike(int $a, int $b, int $c): array
    {
        return func_get_args();
    }
}
