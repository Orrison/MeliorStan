<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class BasicUnused
{
    public function withUnused(): int
    {
        $used = 1;
        $unused = 2;

        return $used;
    }

    public function allUsed(): int
    {
        $a = 1;
        $b = 2;

        return $a + $b;
    }

    public function reassignedButReadOnce(): int
    {
        $value = 1;
        $value = 2;

        return $value;
    }
}
