<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity\Fixture;

class LowComplexityClass
{
    // Complexity: 1 (no decision points)
    public function simpleMethod(): void
    {
        $x = 1;
    }

    // Complexity: 2 (1 if)
    public function methodWithOneIf(): void
    {
        if (true) {
            echo 'test';
        }
    }

    // Complexity: 5 (4 decision points)
    public function methodWithComplexityFive(int $a, int $b): void
    {
        if ($a > 0) {
            echo 'positive';
        } elseif ($a < 0) {
            echo 'negative';
        }

        while ($b > 0) {
            $b--;
        }

        for ($i = 0; $i < 5; $i++) {
            echo $i;
        }
    }
}
