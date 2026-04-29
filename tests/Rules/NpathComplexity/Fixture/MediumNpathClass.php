<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity\Fixture;

class MediumNpathClass
{
    // NPath = 2^6 = 64 (six independent if statements — exceeds threshold of 32 but not 200)
    public function moderateMethod(int $a, int $b, int $c, int $d, int $e, int $f): void
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
    }
}
