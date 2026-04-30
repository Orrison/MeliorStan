<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class LinearIfsClass
{
    public function process(int $a, int $b, int $c, int $d, int $e): void
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
    }
}
