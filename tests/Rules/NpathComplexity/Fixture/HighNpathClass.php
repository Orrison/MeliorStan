<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity\Fixture;

class HighNpathClass
{
    // NPath = 2^8 = 256 (eight independent if statements)
    public function processOrder(int $a, int $b, int $c, int $d, int $e, int $f, int $g, int $h): void
    {
        if ($a > 0) {
            echo 'a';
        }

        if ($b > 0) {
            echo 'b';
        }

        if ($c > 0) {
            echo 'c';
        }

        if ($d > 0) {
            echo 'd';
        }

        if ($e > 0) {
            echo 'e';
        }

        if ($f > 0) {
            echo 'f';
        }

        if ($g > 0) {
            echo 'g';
        }

        if ($h > 0) {
            echo 'h';
        }
    }
}
