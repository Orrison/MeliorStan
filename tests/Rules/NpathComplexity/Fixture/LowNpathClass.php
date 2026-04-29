<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity\Fixture;

class LowNpathClass
{
    // NPath = 4 (two independent if statements)
    public function simpleMethod(int $a, int $b): void
    {
        if ($a > 0) {
            echo 'a';
        }

        if ($b > 0) {
            echo 'b';
        }
    }
}
