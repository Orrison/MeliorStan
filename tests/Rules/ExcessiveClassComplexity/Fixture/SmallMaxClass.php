<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassComplexity\Fixture;

class SmallMaxClass
{
    // Complexity: 3
    public function methodOne(int $a): string
    {
        if ($a > 0) {
            return 'positive';
        } elseif ($a < 0) {
            return 'negative';
        }

        return 'zero';
    }

    // Complexity: 3
    public function methodTwo(int $b): string
    {
        if ($b > 10) {
            return 'high';
        } elseif ($b > 0) {
            return 'low';
        }

        return 'none';
    }
}
