<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class ExceptionsFixture
{
    public function method(): int
    {
        $unused = 1;
        $tmp = 2;
        $reported = 3;

        return 0;
    }
}
