<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength\Fixture;

class PaddedMethodClass
{
    public function paddedMethod(): void
    {
        // Initialize state
        $a = 1;

        $b = 2;

        $c = 3;

        $d = 4;

        $e = 5;

        $f = 6;

        $g = 7;
    }

    public function genuinelyLongMethod(): void
    {
        $x1 = 1;
        $x2 = 2;
        $x3 = 3;
        $x4 = 4;
        $x5 = 5;
        $x6 = 6;
        $x7 = 7;
        $x8 = 8;
        $x9 = 9;
        $x10 = 10;
    }
}
