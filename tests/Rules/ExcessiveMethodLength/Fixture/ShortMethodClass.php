<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength\Fixture;

class ShortMethodClass
{
    public function methodOne(): int
    {
        return 1;
    }

    public function methodTwo(): int
    {
        return 2;
    }
}
