<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class RecursionClass
{
    public function factorial(int $n): int
    {
        if ($n <= 1) {
            return 1;
        }

        return $n * $this->factorial($n - 1);
    }
}
